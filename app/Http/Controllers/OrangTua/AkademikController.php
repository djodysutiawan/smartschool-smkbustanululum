<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\PengumpulanTugas;
use App\Models\TahunAjaran;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkademikController extends Controller
{
    // ── Helper: ambil data orang tua yang login ───────────────────────────────

    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        abort_if(! $orangTua, 403, 'Akun Anda tidak terhubung dengan data orang tua.');
        return $orangTua;
    }

    /**
     * Pastikan siswa adalah anak dari orang tua yang login.
     * Jika ada lebih dari 1 anak, bisa dipilih via query string ?siswa_id=X
     */
    private function resolveAnak(Request $request, $orangTua)
    {
        $anakList = $orangTua->siswa()->with('kelas')->get();
        abort_if($anakList->isEmpty(), 404, 'Data anak tidak ditemukan.');

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', (int) $request->siswa_id);
            abort_if(! $anak, 403, 'Siswa ini bukan anak Anda.');
            return $anak;
        }

        return $anakList->first();
    }

    /**
     * Tahun ajaran yang sedang aktif atau paling baru.
     */
    private function resolveTahunAjaran(Request $request): ?TahunAjaran
    {
        if ($request->filled('tahun_ajaran_id')) {
            return TahunAjaran::find($request->tahun_ajaran_id);
        }
        return TahunAjaran::aktif()->first()
            ?? TahunAjaran::orderByDesc('tahun')->first();
    }

    // ── NILAI PER MATA PELAJARAN ───────────────────────────────────────────────
    // GET /ortu/akademik/nilai

    public function nilai(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahunAjaran   = $this->resolveTahunAjaran($request);
        $tahunAjaranId = $tahunAjaran?->id;

        // Ambil semua nilai anak pada tahun ajaran yang dipilih
        $nilaiList = Nilai::with(['mataPelajaran', 'guru', 'tahunAjaran'])
            ->where('siswa_id', $anak->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->when($request->filled('mapel_id'), fn ($q) => $q->where('mata_pelajaran_id', $request->mapel_id))
            ->orderBy('mata_pelajaran_id')
            ->get();

        // Daftar mapel yang pernah ada nilainya (untuk filter)
        $mapelList = MataPelajaran::whereHas('nilai', fn ($q) =>
            $q->where('siswa_id', $anak->id)
        )->orderBy('nama_mapel')->get();

        $tahunList = TahunAjaran::orderByDesc('tahun')->get();

        // Statistik ringkas per mapel (rata-rata semua komponen)
        // FIX: avg() pada collection of Eloquent model sudah benar,
        // tapi guard null agar tidak ada warning pada mapel tanpa nilai.
        $statsPerMapel = $nilaiList->groupBy('mata_pelajaran_id')->map(function ($group) {
            $row = $group->first();

            // FIX: filter null sebelum avg agar tidak terdistorsi
            $avgField = fn (string $field) => $group->whereNotNull($field)->avg($field);

            return [
                'nama'         => $row->mataPelajaran->nama_mapel ?? '-',
                'nilai_tugas'  => round((float) ($avgField('nilai_tugas') ?? 0), 1),
                'nilai_harian' => round((float) ($avgField('nilai_harian') ?? 0), 1),
                'nilai_uts'    => round((float) ($avgField('nilai_uts') ?? 0), 1),
                'nilai_uas'    => round((float) ($avgField('nilai_uas') ?? 0), 1),
                'nilai_akhir'  => round((float) ($avgField('nilai_akhir') ?? 0), 1),
                'predikat'     => $row->predikat ?? '-',
            ];
        });

        // FIX: filter nilai_akhir > 0 / not-null sebelum avg agar tidak salah
        $rataRataAkhir = $nilaiList->whereNotNull('nilai_akhir')->avg('nilai_akhir');

        // FIX: nilai tertinggi & terendah dari statsPerMapel dengan guard null
        $nilaiTertinggi = $statsPerMapel->isNotEmpty()
            ? $statsPerMapel->max('nilai_akhir')
            : null;

        $nilaiTerendah = $statsPerMapel->isNotEmpty()
            ? $statsPerMapel->min('nilai_akhir')
            : null;

        return view('orangtua.akademik.nilai', compact(
            'anak',
            'anakList',
            'nilaiList',
            'mapelList',
            'tahunList',
            'tahunAjaran',
            'tahunAjaranId',
            'statsPerMapel',
            'rataRataAkhir',
            'nilaiTertinggi',
            'nilaiTerendah',
        ));
    }

    // ── REKAP / RAPOR ─────────────────────────────────────────────────────────
    // GET /ortu/akademik/rapor

    public function rapor(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahunAjaran   = $this->resolveTahunAjaran($request);
        $tahunAjaranId = $tahunAjaran?->id;

        // Ambil semua nilai anak, satu baris per mata pelajaran per tahun ajaran
        $nilaiAll = Nilai::with(['mataPelajaran', 'guru'])
            ->where('siswa_id', $anak->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->get();

        // Susun data rapor per mata pelajaran
        // Jika ada beberapa record per mapel, ambil yang paling baru (updated_at terbesar)
        $raporData = $nilaiAll
            ->groupBy('mata_pelajaran_id')
            ->map(function ($group) {
                $latest = $group->sortByDesc('updated_at')->first();
                return [
                    'mapel'        => $latest->mataPelajaran,
                    'guru'         => $latest->guru,
                    'nilai_tugas'  => $latest->nilai_tugas,
                    'nilai_harian' => $latest->nilai_harian,
                    'nilai_uts'    => $latest->nilai_uts,
                    'nilai_uas'    => $latest->nilai_uas,
                    // FIX: guard null — nilai_akhir bisa null jika belum ada komponen
                    'nilai_akhir'  => $latest->nilai_akhir,
                    'predikat'     => $latest->predikat,
                    'catatan'      => $latest->catatan,
                ];
            })
            ->sortBy(fn ($r) => $r['mapel']->nama_mapel ?? '')
            ->values();

        // FIX: avg pada Collection of array — harus pakai arrow function manual
        // karena ->avg('key') hanya bekerja pada Eloquent collection, bukan array collection.
        $rataRata = $raporData->isNotEmpty()
            ? $raporData
                ->whereNotNull('nilai_akhir')
                ->pipe(fn ($col) => $col->isNotEmpty()
                    ? $col->sum(fn ($r) => (float) $r['nilai_akhir']) / $col->count()
                    : null)
            : null;

        $tahunList = TahunAjaran::orderByDesc('tahun')->get();

        // Hitung sebaran predikat
        $sebaranPredikat = $raporData
            ->whereNotNull('predikat')
            ->groupBy('predikat')
            ->map->count();

        // Mapel dengan nilai akhir terendah & tertinggi
        // FIX: filter null agar sortBy tidak salah urutan
        $raporFiltered  = $raporData->whereNotNull('nilai_akhir');
        $nilaiTertinggi = $raporFiltered->isNotEmpty()
            ? $raporFiltered->sortByDesc('nilai_akhir')->first()
            : null;
        $nilaiTerendah  = $raporFiltered->isNotEmpty()
            ? $raporFiltered->sortBy('nilai_akhir')->first()
            : null;

        return view('orangtua.akademik.rapor', compact(
            'anak',
            'anakList',
            'raporData',
            'rataRata',
            'tahunList',
            'tahunAjaran',
            'tahunAjaranId',
            'sebaranPredikat',
            'nilaiTertinggi',
            'nilaiTerendah',
        ));
    }

    // ── PROGRESS TUGAS ────────────────────────────────────────────────────────
    // GET /ortu/akademik/tugas

    public function tugas(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        // FIX: filter status sekarang benar-benar dipakai di query
        $filterStatus = $request->get('status'); // belum | sudah | terlambat | dinilai

        // FIX: filter tahun ajaran untuk tugas juga diterapkan konsisten
        $tahunAjaran   = $this->resolveTahunAjaran($request);
        $tahunAjaranId = $tahunAjaran?->id;

        // Query dasar tugas untuk kelas anak
        $tugasQuery = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $anak->kelas_id)
            ->where('dipublikasikan', true)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->orderByDesc('batas_waktu');

        // FIX: filter berdasarkan status pengumpulan
        // Ini dilakukan dengan subquery ke pengumpulan_tugas
        if ($filterStatus === 'sudah') {
            $tugasQuery->whereHas('pengumpulan', fn ($q) =>
                $q->where('siswa_id', $anak->id)
                  ->whereNotNull('dikumpulkan_pada')
                  ->where('status', '!=', PengumpulanTugas::STATUS_TERLAMBAT)
            );
        } elseif ($filterStatus === 'terlambat') {
            $tugasQuery->whereHas('pengumpulan', fn ($q) =>
                $q->where('siswa_id', $anak->id)
                  ->where('status', PengumpulanTugas::STATUS_TERLAMBAT)
            );
        } elseif ($filterStatus === 'dinilai') {
            $tugasQuery->whereHas('pengumpulan', fn ($q) =>
                $q->where('siswa_id', $anak->id)
                  ->where('status', PengumpulanTugas::STATUS_DINILAI)
            );
        } elseif ($filterStatus === 'belum') {
            $tugasQuery->whereDoesntHave('pengumpulan', fn ($q) =>
                $q->where('siswa_id', $anak->id)
                  ->whereNotNull('dikumpulkan_pada')
            );
        }

        $tugasAll = $tugasQuery->paginate(15)->withQueryString();

        // FIX: eager load relasi 'tugas' pada PengumpulanTugas agar isTerlambat()
        // tidak memicu N+1 query (lihat PengumpulanTugas::isTerlambat()).
        $pengumpulanMap = PengumpulanTugas::with('tugas')
            ->where('siswa_id', $anak->id)
            ->whereIn('tugas_id', $tugasAll->pluck('id'))
            ->get()
            ->keyBy('tugas_id');

        // Statistik cepat (dari semua tugas kelas anak, tanpa paginasi/filter status)
        $semuaTugasIds = Tugas::where('kelas_id', $anak->kelas_id)
            ->where('dipublikasikan', true)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->pluck('id');

        $semuaPengumpulan = PengumpulanTugas::where('siswa_id', $anak->id)
            ->whereIn('tugas_id', $semuaTugasIds)
            ->get();

        $statTugas = [
            'total'       => $semuaTugasIds->count(),
            'dikumpulkan' => $semuaPengumpulan->whereNotNull('dikumpulkan_pada')->count(),
            'dinilai'     => $semuaPengumpulan->where('status', PengumpulanTugas::STATUS_DINILAI)->count(),
            // FIX: guard avg — jika tidak ada nilai, kembalikan 0 bukan null
            'rata_nilai'  => round(
                (float) ($semuaPengumpulan->whereNotNull('nilai')->avg('nilai') ?? 0),
                1
            ),
        ];

        return view('orangtua.akademik.tugas', compact(
            'anak',
            'anakList',
            'tugasAll',
            'pengumpulanMap',
            'statTugas',
            'filterStatus',
            'tahunAjaran',
            'tahunAjaranId',
        ));
    }
}