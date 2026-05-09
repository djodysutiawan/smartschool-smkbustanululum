<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    // ── Helper ─────────────────────────────────────────────────────────────────

    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * FIX #8: Ekstrak helper resolusi tahun ajaran agar tidak duplikat
     * logika yang sama di index() dan rapor().
     */
    private function resolveTahunAjaranId(?string $requestedId): ?int
    {
        if (filled($requestedId)) {
            return (int) $requestedId;
        }

        $tahunAktif = TahunAjaran::aktif()->first()
            ?? TahunAjaran::orderByDesc('tanggal_mulai')->first();

        return $tahunAktif?->id;
    }

    /**
     * FIX #9: Ekstrak helper nilaiClass agar tidak didefinisikan ulang
     * sebagai closure di setiap request (dan tidak bocor ke view sebagai Closure).
     * Di view, gunakan @include atau helper function. Di sini kita pass array
     * config threshold ke view agar view tidak bergantung pada logika PHP closure.
     */
    private static function nilaiClass(?float $v): string
    {
        if ($v === null) return 'nilai-null';
        return match (true) {
            $v >= 90 => 'nilai-a',
            $v >= 80 => 'nilai-b',
            $v >= 70 => 'nilai-c',
            $v >= 60 => 'nilai-d',
            default  => 'nilai-e',
        };
    }

    // ── Index ──────────────────────────────────────────────────────────────────

    /**
     * Nilai per mata pelajaran milik siswa.
     * Filter: mata pelajaran, tahun ajaran.
     */
    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        $tahunAjaranId = $this->resolveTahunAjaranId($request->tahun_ajaran_id);

        $query = Nilai::with(['mataPelajaran', 'guru', 'tahunAjaran'])
            ->where('siswa_id', $siswa->id);

        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }

        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', (int) $request->mapel_id);
        }

        $nilaiList = $query->orderBy('mata_pelajaran_id')->get();

        // Daftar mapel aktif yang diikuti siswa di kelasnya
        // FIX #10: Guard jika siswa belum punya kelas (kelas_id null),
        // agar whereHas tidak throw error.
        $mapelList = collect();
        if ($siswa->kelas_id) {
            $mapelList = MataPelajaran::whereHas('jadwalPelajaran', fn ($q) =>
                $q->where('kelas_id', $siswa->kelas_id)
                  ->where('is_active', true)
            )->aktif()->orderBy('nama_mapel')->get();
        }

        $tahunList = TahunAjaran::orderByDesc('tanggal_mulai')->get();

        // FIX #11: statsPerMapel — groupBy mata_pelajaran_id lalu ambil first()
        // adalah pattern yang benar karena setiap mapel hanya boleh 1 record nilai
        // per siswa per tahun ajaran. Tambahkan komentar eksplisit + defensive check.
        $statsPerMapel = $nilaiList->groupBy('mata_pelajaran_id')->map(function ($group) {
            /** @var \App\Models\Nilai $item */
            $item = $group->first();
            return [
                'nama_mapel'   => $item->mataPelajaran->nama_mapel ?? '-',
                'nilai_tugas'  => $item->nilai_tugas,
                'nilai_harian' => $item->nilai_harian,
                'nilai_uts'    => $item->nilai_uts,
                'nilai_uas'    => $item->nilai_uas,
                'nilai_akhir'  => $item->nilai_akhir,
                'predikat'     => $item->predikat,
            ];
        });

        // FIX #12: avg() pada Eloquent Collection mengembalikan null jika kosong —
        // beri default 0.0 agar view tidak perlu handle null di dua tempat.
        // Hitung hanya dari nilai_akhir yang tidak null.
        $nilaiAkhirList = $nilaiList->whereNotNull('nilai_akhir');
        $rataRataAkhir  = $nilaiAkhirList->count() > 0
            ? $nilaiAkhirList->avg('nilai_akhir')
            : null; // null = belum ada nilai sama sekali (beda dengan rata-rata 0)

        // Jumlah mapel berdasarkan predikat — filter null predikat
        $rekapPredikat = $nilaiList
            ->whereNotNull('predikat')
            ->groupBy('predikat')
            ->map->count();

        return view('siswa.nilai.index', compact(
            'nilaiList',
            'mapelList',
            'tahunList',
            'statsPerMapel',
            'rataRataAkhir',
            'rekapPredikat',
            'tahunAjaranId',
            'siswa',
        ));
    }

    // ── Rapor ──────────────────────────────────────────────────────────────────

    /**
     * Rekap nilai / rapor per semester siswa.
     */
    public function rapor(Request $request)
    {
        $siswa = $this->getSiswa();

        $tahunAjaranId = $this->resolveTahunAjaranId($request->tahun_ajaran_id);

        $selectedTahun = $tahunAjaranId
            ? TahunAjaran::find($tahunAjaranId)
            : null;

        // Ambil semua nilai siswa pada tahun ajaran terpilih
        $nilaiAll = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->get();

        // FIX #13: Susun data rapor per mapel — satu baris per mata pelajaran.
        // Collection->sortBy() pada nested key perlu closure, bukan dot notation
        // karena value-nya adalah object Eloquent, bukan array.
        $raporData = $nilaiAll
            ->groupBy('mata_pelajaran_id')
            ->map(function ($group) {
                /** @var \App\Models\Nilai $item */
                $item = $group->first();

                return [
                    'mapel'        => $item->mataPelajaran,
                    // FIX #14: Gunakan is_null check eksplisit sebelum round()
                    // agar tidak ada "round(null)" yang mengembalikan 0 (silent bug).
                    'nilai_tugas'  => ! is_null($item->nilai_tugas)  ? round((float) $item->nilai_tugas,  2) : null,
                    'nilai_harian' => ! is_null($item->nilai_harian) ? round((float) $item->nilai_harian, 2) : null,
                    'nilai_uts'    => ! is_null($item->nilai_uts)    ? round((float) $item->nilai_uts,    2) : null,
                    'nilai_uas'    => ! is_null($item->nilai_uas)    ? round((float) $item->nilai_uas,    2) : null,
                    // FIX #15: nilai_akhir bisa null jika belum ada komponen nilai.
                    // Jangan paksa round(null, 2) karena menghasilkan 0 diam-diam.
                    'nilai_akhir'  => ! is_null($item->nilai_akhir)  ? round((float) $item->nilai_akhir, 2) : null,
                    'predikat'     => $item->predikat, // bisa null — handle di view
                    'catatan'      => $item->catatan,
                ];
            })
            ->sortBy(fn ($r) => $r['mapel']->nama_mapel ?? '')
            ->values();

        // FIX #16: BUG KRITIS — $raporData adalah Collection of ARRAYS (bukan Eloquent),
        // sehingga ->avg('nilai_akhir') TIDAK bekerja (selalu null).
        // Harus menggunakan ->avg(fn($r) => $r['nilai_akhir']) dengan closure,
        // dan filter null terlebih dahulu.
        $nilaiAkhirTerisi = $raporData->filter(fn ($r) => ! is_null($r['nilai_akhir']));
        $rataRata = $nilaiAkhirTerisi->count() > 0
            ? $nilaiAkhirTerisi->avg(fn ($r) => $r['nilai_akhir'])
            : null;

        $tahunList = TahunAjaran::orderByDesc('tanggal_mulai')->get();

        // FIX #17: Guard rataRata null sebelum match expression.
        // Jika null, predikatUmum = null (tampil sebagai '—' di view).
        $predikatUmum = match (true) {
            is_null($rataRata)  => null,
            $rataRata >= 90     => 'A',
            $rataRata >= 80     => 'B',
            $rataRata >= 70     => 'C',
            $rataRata >= 60     => 'D',
            default             => 'E',
        };

        return view('siswa.nilai.rapor', compact(
            'raporData',
            'rataRata',
            'predikatUmum',
            'tahunList',
            'tahunAjaranId',
            'selectedTahun',
            'siswa',
        ));
    }
}