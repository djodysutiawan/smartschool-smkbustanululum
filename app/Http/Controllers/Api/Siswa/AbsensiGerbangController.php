<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGerbang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiGerbangController extends Controller
{
    // ── Helper ────────────────────────────────────────────────────────────────

    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()?->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    private function formatScan(AbsensiGerbang $scan): array
    {
        return [
            'id'           => $scan->id,
            'tipe'         => $scan->tipe,
            'status'       => $scan->status,
            'tanggal_scan' => $scan->tanggal_scan?->format('Y-m-d'),
            'waktu_scan'   => $scan->waktu_scan?->format('H:i:s'),
            'keterangan'   => $scan->keterangan ?? null,
            'sesi_gerbang' => $scan->relationLoaded('sesiGerbang') && $scan->sesiGerbang
                ? [
                    'id'   => $scan->sesiGerbang->id,
                    'nama' => $scan->sesiGerbang->nama ?? null,
                ]
                : null,
        ];
    }

    // ── STATUS HARI INI ───────────────────────────────────────────────────────

    /**
     * GET /api/siswa/absensi-gerbang/status-hari-ini
     */
    public function statusHariIni(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $scanHariIni = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $siswa->id)
            ->valid()
            ->hariIni()
            ->orderBy('waktu_scan')
            ->get();

        $scanMasuk  = $scanHariIni->firstWhere('tipe', 'masuk');
        $scanPulang = $scanHariIni->firstWhere('tipe', 'pulang');

        return response()->json([
            'success' => true,
            'data'    => [
                'tanggal'     => now()->toDateString(),
                'scan_masuk'  => $scanMasuk  ? $this->formatScan($scanMasuk)  : null,
                'scan_pulang' => $scanPulang ? $this->formatScan($scanPulang) : null,
                'semua_scan'  => $scanHariIni->map(fn ($s) => $this->formatScan($s))->values(),
            ],
        ]);
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/absensi-gerbang/riwayat
     *
     * Query string:
     *   tanggal_dari   → YYYY-MM-DD (opsional)
     *   tanggal_sampai → YYYY-MM-DD (opsional)
     *   tipe           → masuk|pulang (opsional)
     *   per_page       → int, default 20
     */
    public function riwayat(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $request->validate([
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
            'tipe'           => ['nullable', 'in:masuk,pulang'],
            'per_page'       => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $siswa->id)
            ->orderBy('waktu_scan', 'desc');

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_scan', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_scan', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $perPage = (int) ($request->per_page ?? 20);
        $riwayat = $query->paginate($perPage)->withQueryString();

        // Rekap keseluruhan (tidak terpengaruh filter)
        $rekapBase = AbsensiGerbang::where('siswa_id', $siswa->id)->valid();

        $totalHariMasuk  = (clone $rekapBase)->masuk()->distinct('tanggal_scan')->count('tanggal_scan');
        $totalHariPulang = (clone $rekapBase)->pulang()->distinct('tanggal_scan')->count('tanggal_scan');

        return response()->json([
            'success' => true,
            'data'    => [
                'rekap' => [
                    'total_hari_masuk'  => $totalHariMasuk,
                    'total_hari_pulang' => $totalHariPulang,
                ],
                'riwayat' => [
                    'data'          => collect($riwayat->items())->map(fn ($s) => $this->formatScan($s))->values(),
                    'current_page'  => $riwayat->currentPage(),
                    'last_page'     => $riwayat->lastPage(),
                    'per_page'      => $riwayat->perPage(),
                    'total'         => $riwayat->total(),
                ],
            ],
        ]);
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/absensi-gerbang/{absensiGerbangId}
     */
    public function show(int $absensiGerbangId): JsonResponse
    {
        $siswa = $this->getSiswa();

        $absensiGerbang = AbsensiGerbang::findOrFail($absensiGerbangId);

        abort_if(
            $absensiGerbang->siswa_id !== $siswa->id,
            403,
            'Anda tidak memiliki akses ke data ini.'
        );

        $absensiGerbang->loadMissing(['sesiGerbang', 'siswa.kelas', 'inputOleh', 'koreksiDari']);

        $data = $this->formatScan($absensiGerbang);

        // Tambahan detail untuk endpoint show
        $data['input_oleh']    = $absensiGerbang->inputOleh?->name ?? null;
        $data['koreksi_dari']  = $absensiGerbang->koreksiDari
            ? $this->formatScan($absensiGerbang->koreksiDari)
            : null;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}