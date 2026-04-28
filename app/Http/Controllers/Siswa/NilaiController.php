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
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Nilai per mata pelajaran milik siswa.
     * Filter: mata pelajaran, tahun ajaran.
     */
    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        // Tahun ajaran aktif sebagai default
        $tahunAjaran = TahunAjaran::aktif()->first()
            ?? TahunAjaran::orderByDesc('tanggal_mulai')->first();

        $tahunAjaranId = $request->filled('tahun_ajaran_id')
            ? $request->tahun_ajaran_id
            : $tahunAjaran?->id;

        $query = Nilai::with(['mataPelajaran', 'guru', 'tahunAjaran'])
            ->where('siswa_id', $siswa->id);

        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }

        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', $request->mapel_id);
        }

        $nilaiList = $query->orderBy('mata_pelajaran_id')->get();

        // Daftar mapel aktif yang diikuti siswa di kelasnya
        $mapelList = MataPelajaran::whereHas('jadwalPelajaran', fn ($q) =>
            $q->where('kelas_id', $siswa->kelas_id)
              ->where('is_active', true)
        )->aktif()->orderBy('nama_mapel')->get();

        $tahunList = TahunAjaran::orderByDesc('tanggal_mulai')->get();

        // Statistik ringkas per mapel
        $statsPerMapel = $nilaiList->groupBy('mata_pelajaran_id')->map(function ($group) {
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

        // Rata-rata nilai akhir keseluruhan
        $rataRataAkhir = $nilaiList->avg('nilai_akhir');

        // Jumlah mapel berdasarkan predikat
        $rekapPredikat = $nilaiList->groupBy('predikat')->map->count();

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

    /**
     * Rekap nilai / rapor per semester siswa.
     */
    public function rapor(Request $request)
    {
        $siswa = $this->getSiswa();

        $tahunAjaran = TahunAjaran::aktif()->first()
            ?? TahunAjaran::orderByDesc('tanggal_mulai')->first();

        $tahunAjaranId = $request->filled('tahun_ajaran_id')
            ? $request->tahun_ajaran_id
            : $tahunAjaran?->id;

        $selectedTahun = $tahunAjaranId
            ? TahunAjaran::find($tahunAjaranId)
            : $tahunAjaran;

        // Ambil semua nilai siswa pada tahun ajaran terpilih
        $nilaiAll = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->get();

        // Susun data rapor per mapel — satu baris per mata pelajaran
        $raporData = $nilaiAll->groupBy('mata_pelajaran_id')->map(function ($group) {
            $item = $group->first(); // setiap mapel hanya 1 record nilai per tahun ajaran
            return [
                'mapel'        => $item->mataPelajaran,
                'nilai_tugas'  => $item->nilai_tugas  ? round($item->nilai_tugas, 2)  : null,
                'nilai_harian' => $item->nilai_harian ? round($item->nilai_harian, 2) : null,
                'nilai_uts'    => $item->nilai_uts    ? round($item->nilai_uts, 2)    : null,
                'nilai_uas'    => $item->nilai_uas    ? round($item->nilai_uas, 2)    : null,
                'nilai_akhir'  => round($item->nilai_akhir ?? 0, 2),
                'predikat'     => $item->predikat ?? 'E',
                'catatan'      => $item->catatan,
            ];
        })->sortBy('mapel.nama_mapel')->values();

        $rataRata  = $raporData->avg('nilai_akhir');
        $tahunList = TahunAjaran::orderByDesc('tanggal_mulai')->get();

        // Predikat keseluruhan berdasarkan rata-rata
        $predikatUmum = match (true) {
            $rataRata >= 90 => 'A',
            $rataRata >= 80 => 'B',
            $rataRata >= 70 => 'C',
            $rataRata >= 60 => 'D',
            default         => 'E',
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