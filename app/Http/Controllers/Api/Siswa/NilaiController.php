<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Illuminate\Http\JsonResponse;
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
     * GET /api/siswa/nilai
     * Nilai per mata pelajaran.
     * Query: ?tahun_ajaran_id=&mapel_id=
     */
    public function index(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

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

        $mapelList = MataPelajaran::whereHas('jadwalPelajaran', fn ($q) =>
            $q->where('kelas_id', $siswa->kelas_id)->where('is_active', true)
        )->aktif()->orderBy('nama_mapel')->get(['id', 'nama_mapel']);

        $tahunList = TahunAjaran::orderByDesc('tanggal_mulai')->get();

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

        $rataRataAkhir = $nilaiList->avg('nilai_akhir');
        $rekapPredikat = $nilaiList->groupBy('predikat')->map->count();

        return response()->json([
            'success' => true,
            'data'    => [
                'nilai_list'      => $nilaiList,
                'stats_per_mapel' => $statsPerMapel,
                'rata_rata_akhir' => round($rataRataAkhir ?? 0, 2),
                'rekap_predikat'  => $rekapPredikat,
                'mapel_list'      => $mapelList,
                'tahun_list'      => $tahunList,
                'tahun_ajaran_id' => $tahunAjaranId,
            ],
        ]);
    }

    /**
     * GET /api/siswa/nilai/rapor
     * Rekap nilai / rapor per tahun ajaran.
     * Query: ?tahun_ajaran_id=
     */
    public function rapor(Request $request): JsonResponse
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

        $nilaiAll = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->get();

        $raporData = $nilaiAll->groupBy('mata_pelajaran_id')->map(function ($group) {
            $item = $group->first();
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

        $rataRata = $raporData->avg('nilai_akhir');

        $predikatUmum = match (true) {
            $rataRata >= 90 => 'A',
            $rataRata >= 80 => 'B',
            $rataRata >= 70 => 'C',
            $rataRata >= 60 => 'D',
            default         => 'E',
        };

        return response()->json([
            'success' => true,
            'data'    => [
                'rapor_data'      => $raporData,
                'rata_rata'       => round($rataRata ?? 0, 2),
                'predikat_umum'   => $predikatUmum,
                'tahun_list'      => TahunAjaran::orderByDesc('tanggal_mulai')->get(),
                'tahun_ajaran_id' => $tahunAjaranId,
                'selected_tahun'  => $selectedTahun,
            ],
        ]);
    }
}