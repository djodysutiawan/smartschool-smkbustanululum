<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGerbang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehadiranGerbangController extends Controller
{
    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;

        abort_if(! $orangTua, 403, 'Akun Anda tidak terhubung dengan data orang tua.');

        return $orangTua;
    }

    /**
     * Resolve anak yang dimaksud dari query ?siswa_id=.
     * Jika tidak disertakan, kembalikan anak pertama.
     * Pastikan siswa yang diminta memang anak dari orangTua ini.
     */
    private function resolveAnak(Request $request, $orangTua)
    {
        $anakList = $orangTua->siswa()->get();

        abort_if($anakList->isEmpty(), 404, 'Data anak tidak ditemukan.');

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', $request->integer('siswa_id'));
            abort_if(! $anak, 403, 'Siswa ini bukan anak Anda.');
            return $anak;
        }

        return $anakList->first();
    }

    /**
     * Format satu record AbsensiGerbang menjadi array respons.
     */
    private function formatScan(AbsensiGerbang $scan): array
    {
        return [
            'id'          => $scan->id,
            'tipe'        => $scan->tipe,
            'waktu_scan'  => $scan->waktu_scan?->toIso8601String(),
            'tanggal_scan' => $scan->tanggal_scan?->toDateString(),
            'metode'      => $scan->metode ?? null,
            'keterangan'  => $scan->keterangan ?? null,
            'sesi'        => $scan->sesiGerbang ? [
                'id'   => $scan->sesiGerbang->id,
                'nama' => $scan->sesiGerbang->nama,
            ] : null,
        ];
    }

    /**
     * Format data anak ringkas untuk disertakan di setiap respons.
     */
    private function formatAnak($anak): array
    {
        return [
            'id'           => $anak->id,
            'nis'          => $anak->nis,
            'nama_lengkap' => $anak->nama_lengkap,
            'kelas'        => $anak->kelas?->nama_kelas,
            'kelas_id'     => $anak->kelas?->id,
        ];
    }

    // ── STATUS HARI INI ───────────────────────────────────────────────────────

    /**
     * GET /api/ortu/kehadiran-gerbang/status-hari-ini
     * Query: ?siswa_id=
     *
     * Orang tua melihat apakah anak sudah scan masuk/pulang di gerbang hari ini.
     * Hanya scan valid (normal, manual, koreksi) yang ditampilkan.
     *
     * Response:
     * {
     *   "success": true,
     *   "data": {
     *     "anak": { ... },
     *     "anak_list": [ ... ],
     *     "scan_masuk": { ... } | null,
     *     "scan_pulang": { ... } | null,
     *     "semua_scan": [ ... ],
     *     "sudah_masuk": true,
     *     "sudah_pulang": false
     *   }
     * }
     */
    public function statusHariIni(Request $request): JsonResponse
    {
        $request->validate([
            'siswa_id' => ['nullable', 'integer'],
        ]);

        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $scanHariIni = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $anak->id)
            ->valid()
            ->hariIni()
            ->orderBy('waktu_scan')
            ->get();

        $scanMasuk  = $scanHariIni->firstWhere('tipe', 'masuk');
        $scanPulang = $scanHariIni->firstWhere('tipe', 'pulang');

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'         => $this->formatAnak($anak),
                'anak_list'    => $anakList->map(fn ($a) => $this->formatAnak($a))->values(),
                'scan_masuk'   => $scanMasuk  ? $this->formatScan($scanMasuk)  : null,
                'scan_pulang'  => $scanPulang ? $this->formatScan($scanPulang) : null,
                'semua_scan'   => $scanHariIni->map(fn ($s) => $this->formatScan($s))->values(),
                'sudah_masuk'  => $scanMasuk  !== null,
                'sudah_pulang' => $scanPulang !== null,
            ],
        ]);
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * GET /api/ortu/kehadiran-gerbang/riwayat
     * Query: ?siswa_id= &tipe=masuk|pulang &tanggal_dari= &tanggal_sampai= &page=
     *
     * Riwayat seluruh log masuk & pulang anak di gerbang.
     *
     * Response:
     * {
     *   "success": true,
     *   "data": {
     *     "anak": { ... },
     *     "anak_list": [ ... ],
     *     "riwayat": [ ... ],
     *     "ringkasan": {
     *       "total_hari_masuk": 20,
     *       "total_hari_pulang": 18
     *     },
     *     "pagination": { ... }
     *   }
     * }
     */
    public function riwayat(Request $request): JsonResponse
    {
        $request->validate([
            'siswa_id'       => ['nullable', 'integer'],
            'tipe'           => ['nullable', 'in:masuk,pulang'],
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
            'page'           => ['nullable', 'integer', 'min:1'],
        ]);

        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $query = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $anak->id)
            ->valid();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_scan', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_scan', '<=', $request->tanggal_sampai);
        }

        $riwayat = $query->orderByDesc('waktu_scan')->paginate(20)->withQueryString();

        // Total hari unik masuk & pulang (tanpa filter tanggal, untuk ringkasan keseluruhan)
        $totalHariMasuk = AbsensiGerbang::where('siswa_id', $anak->id)
            ->valid()
            ->masuk()
            ->selectRaw('COUNT(DISTINCT tanggal_scan) as total')
            ->value('total') ?? 0;

        $totalHariPulang = AbsensiGerbang::where('siswa_id', $anak->id)
            ->valid()
            ->pulang()
            ->selectRaw('COUNT(DISTINCT tanggal_scan) as total')
            ->value('total') ?? 0;

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'      => $this->formatAnak($anak),
                'anak_list' => $anakList->map(fn ($a) => $this->formatAnak($a))->values(),
                'riwayat'   => $riwayat->map(fn ($s) => $this->formatScan($s))->values(),
                'ringkasan' => [
                    'total_hari_masuk'  => (int) $totalHariMasuk,
                    'total_hari_pulang' => (int) $totalHariPulang,
                ],
                'pagination' => [
                    'current_page' => $riwayat->currentPage(),
                    'last_page'    => $riwayat->lastPage(),
                    'per_page'     => $riwayat->perPage(),
                    'total'        => $riwayat->total(),
                ],
            ],
        ]);
    }

    // ── REKAP ─────────────────────────────────────────────────────────────────

    /**
     * GET /api/ortu/kehadiran-gerbang/rekap
     * Query: ?siswa_id= &bulan= &tahun=
     *
     * Rekap bulanan kehadiran gerbang anak beserta tren tahunan.
     *
     * Response:
     * {
     *   "success": true,
     *   "data": {
     *     "anak": { ... },
     *     "anak_list": [ ... ],
     *     "bulan": 5,
     *     "tahun": 2025,
     *     "rekap": {
     *       "total_hari_masuk": 18,
     *       "total_hari_pulang": 16,
     *       "total_scan": 34
     *     },
     *     "hari_per_tanggal": [
     *       {
     *         "tanggal": "2025-05-01",
     *         "masuk": { ... } | null,
     *         "pulang": { ... } | null
     *       }
     *     ],
     *     "rekap_tahunan": {
     *       "1": { "masuk": 18, "pulang": 16 },
     *       ...
     *       "12": { "masuk": 0, "pulang": 0 }
     *     }
     *   }
     * }
     */
    public function rekap(Request $request): JsonResponse
    {
        $request->validate([
            'siswa_id' => ['nullable', 'integer'],
            'bulan'    => ['nullable', 'integer', 'min:1', 'max:12'],
            'tahun'    => ['nullable', 'integer', 'min:2000', 'max:2100'],
        ]);

        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $bulan = $request->filled('bulan') ? (int) $request->bulan : now()->month;
        $tahun = $request->filled('tahun') ? (int) $request->tahun : now()->year;

        // Scan valid anak bulan yang dipilih
        $scanBulanIni = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $anak->id)
            ->valid()
            ->whereMonth('tanggal_scan', $bulan)
            ->whereYear('tanggal_scan', $tahun)
            ->orderBy('waktu_scan')
            ->get();

        // Kelompokkan per tanggal → pasangkan masuk & pulang
        $hariPerTanggal = $scanBulanIni
            ->groupBy(fn ($s) => $s->tanggal_scan->format('Y-m-d'))
            ->map(fn ($group) => [
                'tanggal' => $group->first()->tanggal_scan->toDateString(),
                'masuk'   => $group->firstWhere('tipe', 'masuk')
                    ? $this->formatScan($group->firstWhere('tipe', 'masuk'))
                    : null,
                'pulang'  => $group->firstWhere('tipe', 'pulang')
                    ? $this->formatScan($group->firstWhere('tipe', 'pulang'))
                    : null,
            ])
            ->values();

        $rekap = [
            'total_hari_masuk'  => $scanBulanIni
                ->where('tipe', 'masuk')
                ->pluck('tanggal_scan')
                ->map(fn ($d) => $d->format('Y-m-d'))
                ->unique()
                ->count(),
            'total_hari_pulang' => $scanBulanIni
                ->where('tipe', 'pulang')
                ->pluck('tanggal_scan')
                ->map(fn ($d) => $d->format('Y-m-d'))
                ->unique()
                ->count(),
            'total_scan'        => $scanBulanIni->count(),
        ];

        // Rekap per bulan untuk tren tahunan
        // Dibuat dalam satu query aggregate per bulan agar efisien
        $rekapTahunan = [];
        for ($m = 1; $m <= 12; $m++) {
            $scanBulan = AbsensiGerbang::where('siswa_id', $anak->id)
                ->valid()
                ->whereMonth('tanggal_scan', $m)
                ->whereYear('tanggal_scan', $tahun)
                ->get();

            $rekapTahunan[$m] = [
                'masuk'  => $scanBulan->where('tipe', 'masuk')
                    ->pluck('tanggal_scan')
                    ->map(fn ($d) => $d->format('Y-m-d'))
                    ->unique()
                    ->count(),
                'pulang' => $scanBulan->where('tipe', 'pulang')
                    ->pluck('tanggal_scan')
                    ->map(fn ($d) => $d->format('Y-m-d'))
                    ->unique()
                    ->count(),
            ];
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'            => $this->formatAnak($anak),
                'anak_list'       => $anakList->map(fn ($a) => $this->formatAnak($a))->values(),
                'bulan'           => $bulan,
                'tahun'           => $tahun,
                'rekap'           => $rekap,
                'hari_per_tanggal' => $hariPerTanggal,
                'rekap_tahunan'   => $rekapTahunan,
            ],
        ]);
    }
}