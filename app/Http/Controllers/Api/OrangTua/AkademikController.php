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
    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        if (! $orangTua) {
            abort(response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak terhubung dengan data orang tua.',
            ], 403));
        }
        return $orangTua;
    }

    private function resolveAnak(Request $request, $orangTua)
    {
        $anakList = $orangTua->siswa()->with('kelas')->get();
        if ($anakList->isEmpty()) {
            abort(response()->json(['success' => false, 'message' => 'Data anak tidak ditemukan.'], 404));
        }

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', (int) $request->siswa_id);
            if (! $anak) {
                abort(response()->json(['success' => false, 'message' => 'Siswa ini bukan anak Anda.'], 403));
            }
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

    // ── Nilai ─────────────────────────────────────────────────────────────────

    /**
     * GET /api/ortu/akademik/nilai
     * Query: ?siswa_id= &tahun_ajaran_id= &mapel_id=
     */
    public function nilai(Request $request): JsonResponse
    {
        $orangTua      = $this->getOrangTua();
        $anak          = $this->resolveAnak($request, $orangTua);
        $anakList      = $orangTua->siswa()->with('kelas')->get();
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

        $avgField = fn ($group, string $field) => $group->whereNotNull($field)->avg($field);

        $statsPerMapel = $nilaiList->groupBy('mata_pelajaran_id')->map(function ($group) use ($avgField) {
            $row = $group->first();
            return [
                'mapel_id'     => $row->mata_pelajaran_id,
                'nama'         => $row->mataPelajaran?->nama_mapel ?? '-',
                'nilai_tugas'  => round((float) ($avgField($group, 'nilai_tugas') ?? 0), 1),
                'nilai_harian' => round((float) ($avgField($group, 'nilai_harian') ?? 0), 1),
                'nilai_uts'    => round((float) ($avgField($group, 'nilai_uts') ?? 0), 1),
                'nilai_uas'    => round((float) ($avgField($group, 'nilai_uas') ?? 0), 1),
                'nilai_akhir'  => round((float) ($avgField($group, 'nilai_akhir') ?? 0), 1),
                'predikat'     => $row->predikat ?? '-',
            ];
        })->values();

        $rataRataAkhir  = round((float) ($nilaiList->whereNotNull('nilai_akhir')->avg('nilai_akhir') ?? 0), 1);
        $nilaiTertinggi = $statsPerMapel->isNotEmpty() ? $statsPerMapel->max('nilai_akhir') : null;
        $nilaiTerendah  = $statsPerMapel->isNotEmpty() ? $statsPerMapel->min('nilai_akhir') : null;

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'           => [
                    'id'           => $anak->id,
                    'nama_lengkap' => $anak->nama_lengkap,
                    'kelas'        => $anak->kelas?->nama_kelas,
                ],
                'anak_list'      => $anakList->map(fn ($a) => [
                    'id'           => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                ])->values(),
                'tahun_ajaran'   => $tahunAjaran ? [
                    'id'    => $tahunAjaran->id,
                    'tahun' => $tahunAjaran->tahun,
                ] : null,
                'tahun_list'     => $tahunList->map(fn ($t) => [
                    'id'    => $t->id,
                    'tahun' => $t->tahun,
                ])->values(),
                'mapel_list'     => $mapelList->map(fn ($m) => [
                    'id'        => $m->id,
                    'nama_mapel' => $m->nama_mapel,
                ])->values(),
                'stats_per_mapel' => $statsPerMapel,
                'rata_rata_akhir' => $rataRataAkhir,
                'nilai_tertinggi' => $nilaiTertinggi,
                'nilai_terendah'  => $nilaiTerendah,
            ],
        ]);
    }

    // ── Rapor ─────────────────────────────────────────────────────────────────

    /**
     * GET /api/ortu/akademik/rapor
     * Query: ?siswa_id= &tahun_ajaran_id=
     */
    public function rapor(Request $request): JsonResponse
    {
        $orangTua      = $this->getOrangTua();
        $anak          = $this->resolveAnak($request, $orangTua);
        $anakList      = $orangTua->siswa()->with('kelas')->get();
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
                    'mapel_id'     => $latest->mata_pelajaran_id,
                    'nama_mapel'   => $latest->mataPelajaran?->nama_mapel,
                    'guru'         => $latest->guru?->nama_lengkap,
                    'nilai_tugas'  => $latest->nilai_tugas,
                    'nilai_harian' => $latest->nilai_harian,
                    'nilai_uts'    => $latest->nilai_uts,
                    'nilai_uas'    => $latest->nilai_uas,
                    'nilai_akhir'  => $latest->nilai_akhir,
                    'predikat'     => $latest->predikat,
                    'catatan'      => $latest->catatan,
                ];
            })
            ->sortBy('nama_mapel')
            ->values();

        $rataRata = $raporData->isNotEmpty()
            ? $raporData->whereNotNull('nilai_akhir')
                ->pipe(fn ($col) => $col->isNotEmpty()
                    ? round($col->sum(fn ($r) => (float) $r['nilai_akhir']) / $col->count(), 1)
                    : null)
            : null;

        $sebaranPredikat = $raporData
            ->whereNotNull('predikat')
            ->groupBy('predikat')
            ->map->count();

        $raporFiltered  = $raporData->whereNotNull('nilai_akhir');
        $nilaiTertinggi = $raporFiltered->isNotEmpty()
            ? $raporFiltered->sortByDesc('nilai_akhir')->first()
            : null;
        $nilaiTerendah  = $raporFiltered->isNotEmpty()
            ? $raporFiltered->sortBy('nilai_akhir')->first()
            : null;

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'             => [
                    'id'           => $anak->id,
                    'nama_lengkap' => $anak->nama_lengkap,
                    'kelas'        => $anak->kelas?->nama_kelas,
                ],
                'anak_list'        => $anakList->map(fn ($a) => [
                    'id'           => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                ])->values(),
                'tahun_ajaran'     => $tahunAjaran ? [
                    'id'    => $tahunAjaran->id,
                    'tahun' => $tahunAjaran->tahun,
                ] : null,
                'rapor_data'       => $raporData,
                'rata_rata'        => $rataRata,
                'sebaran_predikat' => $sebaranPredikat,
                'nilai_tertinggi'  => $nilaiTertinggi,
                'nilai_terendah'   => $nilaiTerendah,
            ],
        ]);
    }

    // ── Tugas ─────────────────────────────────────────────────────────────────

    /**
     * GET /api/ortu/akademik/tugas
     * Query: ?siswa_id= &status= &tahun_ajaran_id= &page=
     *
     * status: belum | sudah | terlambat | dinilai
     */
    public function tugas(Request $request): JsonResponse
    {
        $orangTua      = $this->getOrangTua();
        $anak          = $this->resolveAnak($request, $orangTua);
        $anakList      = $orangTua->siswa()->with('kelas')->get();
        $filterStatus  = $request->get('status');
        $tahunAjaran   = $this->resolveTahunAjaran($request);
        $tahunAjaranId = $tahunAjaran?->id;

        $tugasQuery = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $anak->kelas_id)
            ->where('dipublikasikan', true)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->orderByDesc('batas_waktu');

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
                $q->where('siswa_id', $anak->id)->whereNotNull('dikumpulkan_pada')
            );
        }

        $tugasAll = $tugasQuery->paginate(15)->withQueryString();

        $pengumpulanMap = PengumpulanTugas::with('tugas')
            ->where('siswa_id', $anak->id)
            ->whereIn('tugas_id', $tugasAll->pluck('id'))
            ->get()
            ->keyBy('tugas_id');

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
            'rata_nilai'  => round((float) ($semuaPengumpulan->whereNotNull('nilai')->avg('nilai') ?? 0), 1),
        ];

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'          => [
                    'id'           => $anak->id,
                    'nama_lengkap' => $anak->nama_lengkap,
                    'kelas'        => $anak->kelas?->nama_kelas,
                ],
                'anak_list'     => $anakList->map(fn ($a) => [
                    'id'           => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                ])->values(),
                'stat_tugas'    => $statTugas,
                'filter_status' => $filterStatus,
                'tugas'         => $tugasAll->map(function ($t) use ($pengumpulanMap) {
                    $p = $pengumpulanMap->get($t->id);
                    return [
                        'id'              => $t->id,
                        'judul'           => $t->judul,
                        'deskripsi'       => $t->deskripsi,
                        'mata_pelajaran'  => $t->mataPelajaran?->nama_mapel,
                        'guru'            => $t->guru?->nama_lengkap,
                        'batas_waktu'     => $t->batas_waktu?->toIso8601String(),
                        'pengumpulan'     => $p ? [
                            'status'           => $p->status,
                            'dikumpulkan_pada' => $p->dikumpulkan_pada?->toIso8601String(),
                            'nilai'            => $p->nilai,
                        ] : null,
                    ];
                })->values(),
                'pagination'    => [
                    'current_page' => $tugasAll->currentPage(),
                    'last_page'    => $tugasAll->lastPage(),
                    'per_page'     => $tugasAll->perPage(),
                    'total'        => $tugasAll->total(),
                ],
            ],
        ]);
    }
}