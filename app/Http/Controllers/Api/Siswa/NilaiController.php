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
    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    private function resolveTahunAjaranId(?string $requestedId): ?int
    {
        if (filled($requestedId)) {
            return (int) $requestedId;
        }

        // Coba scope aktif dulu, fallback ke terbaru
        try {
            $tahun = TahunAjaran::aktif()->first();
        } catch (\Exception $e) {
            $tahun = null;
        }

        return ($tahun ?? TahunAjaran::orderByDesc('tanggal_mulai')->first())?->id;
    }

    private static function hitungPredikat(?float $nilai): ?string
    {
        if ($nilai === null) return null;
        return match (true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default      => 'E',
        };
    }

    // ── Index ─────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/nilai
     */
    public function index(Request $request): JsonResponse
    {
        $siswa         = $this->getSiswa();
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

        // Mapel list — guard jika kelas_id null
        $mapelList = collect();
        if ($siswa->kelas_id) {
            try {
                $mapelList = MataPelajaran::whereHas('jadwalPelajaran', fn ($q) =>
                    $q->where('kelas_id', $siswa->kelas_id)
                      ->where('is_active', true)
                )->aktif()->orderBy('nama_mapel')->get(['id', 'nama_mapel']);
            } catch (\Exception $e) {
                // Jika scope aktif atau relasi belum ada, fallback kosong
                $mapelList = collect();
            }
        }

        $tahunList = TahunAjaran::orderByDesc('tanggal_mulai')->get(['id', 'tahun', 'tanggal_mulai']);

        $statsPerMapel = $nilaiList->groupBy('mata_pelajaran_id')->map(function ($group) {
            $item = $group->first();
            return [
                'mata_pelajaran_id' => $item->mata_pelajaran_id,
                'nama_mapel'        => $item->mataPelajaran->nama_mapel ?? '-',
                'nilai_tugas'       => $item->nilai_tugas,
                'nilai_harian'      => $item->nilai_harian,
                'nilai_uts'         => $item->nilai_uts,
                'nilai_uas'         => $item->nilai_uas,
                'nilai_akhir'       => $item->nilai_akhir,
                'predikat'          => $item->predikat,
            ];
        })->values();

        $nilaiAkhirList = $nilaiList->whereNotNull('nilai_akhir');
        $rataRataAkhir  = $nilaiAkhirList->count() > 0
            ? round($nilaiAkhirList->avg('nilai_akhir'), 2)
            : null;

        $rekapPredikat = $nilaiList
            ->whereNotNull('predikat')
            ->groupBy('predikat')
            ->map->count();

        return response()->json([
            'success' => true,
            'data'    => [
                'nilai_list'      => $nilaiList->map(fn ($n) => [
                    'id'             => $n->id,
                    'mata_pelajaran' => $n->mataPelajaran ? [
                        'id'         => $n->mataPelajaran->id,
                        'nama_mapel' => $n->mataPelajaran->nama_mapel,
                    ] : null,
                    'guru' => $n->guru ? [
                        'id'           => $n->guru->id,
                        'nama_lengkap' => $n->guru->nama_lengkap,
                    ] : null,
                    'tahun_ajaran' => $n->tahunAjaran ? [
                        'id'   => $n->tahunAjaran->id,
                        'tahun' => $n->tahunAjaran->tahun ?? null,
                    ] : null,
                    'nilai_tugas'  => $n->nilai_tugas,
                    'nilai_harian' => $n->nilai_harian,
                    'nilai_uts'    => $n->nilai_uts,
                    'nilai_uas'    => $n->nilai_uas,
                    'nilai_akhir'  => $n->nilai_akhir,
                    'predikat'     => $n->predikat,
                    'catatan'      => $n->catatan,
                ])->values(),
                'stats_per_mapel' => $statsPerMapel,
                'rata_rata_akhir' => $rataRataAkhir,
                'rekap_predikat'  => $rekapPredikat,
                'mapel_list'      => $mapelList->map(fn ($m) => [
                    'id'         => $m->id,
                    'nama_mapel' => $m->nama_mapel,
                ])->values(),
                'tahun_list'      => $tahunList->map(fn ($t) => [
                    'id'           => $t->id,
                    'nama'         => $t->tahun ?? null,
                    'tanggal_mulai'=> $t->tanggal_mulai ?? null,
                ])->values(),
                'tahun_ajaran_id' => $tahunAjaranId,
            ],
        ]);
    }

    // ── Rapor ─────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/nilai/rapor
     */
    public function rapor(Request $request): JsonResponse
    {
        $siswa         = $this->getSiswa();
        $tahunAjaranId = $this->resolveTahunAjaranId($request->tahun_ajaran_id);
        $selectedTahun = $tahunAjaranId ? TahunAjaran::find($tahunAjaranId) : null;

        $nilaiAll = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->get();

        $raporData = $nilaiAll
            ->groupBy('mata_pelajaran_id')
            ->map(function ($group) {
                $item = $group->first();
                return [
                    'mata_pelajaran' => [
                        'id'         => $item->mataPelajaran->id ?? null,
                        'nama_mapel' => $item->mataPelajaran->nama_mapel ?? '-',
                    ],
                    'nilai_tugas'  => ! is_null($item->nilai_tugas)  ? round((float) $item->nilai_tugas,  2) : null,
                    'nilai_harian' => ! is_null($item->nilai_harian) ? round((float) $item->nilai_harian, 2) : null,
                    'nilai_uts'    => ! is_null($item->nilai_uts)    ? round((float) $item->nilai_uts,    2) : null,
                    'nilai_uas'    => ! is_null($item->nilai_uas)    ? round((float) $item->nilai_uas,    2) : null,
                    'nilai_akhir'  => ! is_null($item->nilai_akhir)  ? round((float) $item->nilai_akhir,  2) : null,
                    'predikat'     => $item->predikat,
                    'catatan'      => $item->catatan,
                ];
            })
            ->sortBy(fn ($r) => $r['mata_pelajaran']['nama_mapel'] ?? '')
            ->values();

        // avg pada collection of arrays wajib pakai closure
        $nilaiAkhirTerisi = $raporData->filter(fn ($r) => ! is_null($r['nilai_akhir']));
        $rataRata = $nilaiAkhirTerisi->count() > 0
            ? round($nilaiAkhirTerisi->avg(fn ($r) => $r['nilai_akhir']), 2)
            : null;

        $predikatUmum = self::hitungPredikat($rataRata);

        $tahunList = TahunAjaran::orderByDesc('tanggal_mulai')->get(['id', 'tahun', 'tanggal_mulai']);

        return response()->json([
            'success' => true,
            'data'    => [
                'rapor_data'      => $raporData,
                'rata_rata'       => $rataRata,
                'predikat_umum'   => $predikatUmum,
                'tahun_list'      => $tahunList->map(fn ($t) => [
                    'id'            => $t->id,
                    'nama'          => $t->tahun ?? null,
                    'tanggal_mulai' => $t->tanggal_mulai ?? null,
                ])->values(),
                'tahun_ajaran_id' => $tahunAjaranId,
                'selected_tahun'  => $selectedTahun ? [
                    'id'            => $selectedTahun->id,
                    'tahun'          => $selectedTahun->tahun ?? null,
                    'tanggal_mulai' => $selectedTahun->tanggal_mulai?->format('Y-m-d'),
                    'tanggal_selesai' => $selectedTahun->tanggal_selesai?->format('Y-m-d'),
                ] : null,
                'siswa' => [
                    'id'           => $siswa->id,
                    'nis'          => $siswa->nis,
                    'nama_lengkap' => $siswa->nama_lengkap,
                    'kelas'        => $siswa->kelas?->nama_kelas,
                ],
            ],
        ]);
    }
}