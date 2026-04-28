<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\PengumpulanTugas;
use App\Models\TahunAjaran;
use App\Models\Tugas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkademikController extends Controller
{
    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        abort_if(! $orangTua, 403, 'Akun Anda tidak terhubung dengan data orang tua.');
        return $orangTua;
    }

    private function resolveAnak(Request $request, $orangTua)
    {
        $anakList = $orangTua->siswa()->with('kelas')->get();
        abort_if($anakList->isEmpty(), 404, 'Data anak tidak ditemukan.');

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', $request->siswa_id);
            abort_if(! $anak, 403, 'Siswa ini bukan anak Anda.');
            return $anak;
        }

        return $anakList->first();
    }

    private function resolveTahunAjaran(Request $request): ?TahunAjaran
    {
        if ($request->filled('tahun_ajaran_id')) {
            return TahunAjaran::find($request->tahun_ajaran_id);
        }
        return TahunAjaran::aktif()->first()
            ?? TahunAjaran::orderByDesc('tahun')->first();
    }

    /**
     * GET /api/ortu/akademik/nilai
     *
     * Nilai per mata pelajaran anak.
     *
     * Query params:
     *   - siswa_id       (optional)
     *   - tahun_ajaran_id (optional)
     *   - mapel_id       (optional)
     */
    public function nilai(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahunAjaran   = $this->resolveTahunAjaran($request);
        $tahunAjaranId = $tahunAjaran?->id;

        $nilaiList = Nilai::with(['mataPelajaran', 'guru', 'tahunAjaran'])
            ->where('siswa_id', $anak->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->when($request->filled('mapel_id'), fn ($q) => $q->where('mata_pelajaran_id', $request->mapel_id))
            ->orderBy('mata_pelajaran_id')
            ->get();

        $mapelList = MataPelajaran::whereHas('nilai', fn ($q) =>
            $q->where('siswa_id', $anak->id)
        )->orderBy('nama_mapel')->get();

        $tahunList = TahunAjaran::orderByDesc('tahun')->get();

        $statsPerMapel = $nilaiList->groupBy('mata_pelajaran_id')->map(function ($group) {
            $row = $group->first();
            return [
                'nama'         => $row->mataPelajaran->nama_mapel ?? '-',
                'nilai_tugas'  => round($group->avg('nilai_tugas') ?? 0, 1),
                'nilai_harian' => round($group->avg('nilai_harian') ?? 0, 1),
                'nilai_uts'    => round($group->avg('nilai_uts') ?? 0, 1),
                'nilai_uas'    => round($group->avg('nilai_uas') ?? 0, 1),
                'nilai_akhir'  => round($group->avg('nilai_akhir') ?? 0, 1),
                'predikat'     => $row->predikat ?? '-',
            ];
        });

        $rataRataAkhir = $nilaiList->avg('nilai_akhir');

        return response()->json([
            'anak'           => $anak,
            'anak_list'      => $anakList,
            'nilai_list'     => $nilaiList,
            'mapel_list'     => $mapelList,
            'tahun_list'     => $tahunList,
            'tahun_ajaran'   => $tahunAjaran,
            'stats_per_mapel'=> $statsPerMapel->values(),
            'rata_rata_akhir'=> round($rataRataAkhir ?? 0, 1),
        ]);
    }

    /**
     * GET /api/ortu/akademik/rapor
     *
     * Rekap rapor anak per tahun ajaran.
     *
     * Query params:
     *   - siswa_id        (optional)
     *   - tahun_ajaran_id (optional)
     */
    public function rapor(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahunAjaran   = $this->resolveTahunAjaran($request);
        $tahunAjaranId = $tahunAjaran?->id;

        $nilaiAll = Nilai::with(['mataPelajaran', 'guru'])
            ->where('siswa_id', $anak->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->get();

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
                    'nilai_akhir'  => $latest->nilai_akhir,
                    'predikat'     => $latest->predikat,
                    'catatan'      => $latest->catatan,
                ];
            })
            ->sortBy('mapel.nama_mapel')
            ->values();

        $rataRata        = $raporData->avg('nilai_akhir');
        $tahunList       = TahunAjaran::orderByDesc('tahun')->get();
        $sebaranPredikat = $raporData->groupBy('predikat')->map->count();
        $nilaiTertinggi  = $raporData->sortByDesc('nilai_akhir')->first();
        $nilaiTerendah   = $raporData->sortBy('nilai_akhir')->first();

        return response()->json([
            'anak'             => $anak,
            'anak_list'        => $anakList,
            'rapor_data'       => $raporData,
            'rata_rata'        => round($rataRata ?? 0, 1),
            'tahun_list'       => $tahunList,
            'tahun_ajaran'     => $tahunAjaran,
            'sebaran_predikat' => $sebaranPredikat,
            'nilai_tertinggi'  => $nilaiTertinggi,
            'nilai_terendah'   => $nilaiTerendah,
        ]);
    }

    /**
     * GET /api/ortu/akademik/tugas
     *
     * Progress tugas anak.
     *
     * Query params:
     *   - siswa_id  (optional)
     *   - status    (optional) belum|sudah|terlambat
     *   - per_page  (optional, default 15)
     */
    public function tugas(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $perPage = $request->get('per_page', 15);

        $tugasQuery = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $anak->kelas_id)
            ->where('dipublikasikan', true)
            ->orderByDesc('batas_waktu');

        $tugasAll = $tugasQuery->paginate($perPage)->withQueryString();

        $pengumpulanMap = PengumpulanTugas::with('tugas')
            ->where('siswa_id', $anak->id)
            ->whereIn('tugas_id', $tugasAll->pluck('id'))
            ->get()
            ->keyBy('tugas_id');

        $semuaTugas = Tugas::where('kelas_id', $anak->kelas_id)
            ->where('dipublikasikan', true)
            ->pluck('id');

        $semuaPengumpulan = PengumpulanTugas::where('siswa_id', $anak->id)
            ->whereIn('tugas_id', $semuaTugas)
            ->get();

        $statTugas = [
            'total'       => $semuaTugas->count(),
            'dikumpulkan' => $semuaPengumpulan->whereNotNull('dikumpulkan_pada')->count(),
            'dinilai'     => $semuaPengumpulan->where('status', 'sudah_dinilai')->count(),
            'rata_nilai'  => round($semuaPengumpulan->whereNotNull('nilai')->avg('nilai') ?? 0, 1),
        ];

        // Merge pengumpulan into tugas items for convenience
        $tugasItems = $tugasAll->getCollection()->map(function ($tugas) use ($pengumpulanMap) {
            $tugas->pengumpulan = $pengumpulanMap->get($tugas->id);
            return $tugas;
        });

        return response()->json([
            'anak'           => $anak,
            'anak_list'      => $anakList,
            'tugas'          => $tugasAll->setCollection($tugasItems),
            'stat_tugas'     => $statTugas,
        ]);
    }
}