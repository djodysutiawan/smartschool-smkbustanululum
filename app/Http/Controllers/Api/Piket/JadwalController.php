<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\JadwalPiketGuru;
use App\Models\LogPiket;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    use PiketActiveGuru;

    /**
     * GET /api/piket/jadwal
     *
     * Daftar jadwal piket guru yang sedang check-in.
     * Jika belum check-in, kembalikan state kosong.
     *
     * Query params:
     *   - tahun_ajaran_id (optional)
     *   - is_active       (optional) true|false
     *   - per_page        (optional, default 15)
     */
    public function index(Request $request): JsonResponse
    {
        $guruId = $this->resolveActiveGuruId();

        if (! $guruId) {
            return response()->json([
                'belum_checkin'  => true,
                'jadwal'         => [],
                'jadwal_hari_ini'=> null,
                'log_bulan_ini'  => [],
                'rekap_bulan_ini'=> ['hadir' => 0, 'total' => 0],
            ]);
        }

        $query = JadwalPiketGuru::with('tahunAjaran')
            ->where('guru_id', $guruId)
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai');

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $perPage = $request->get('per_page', 15);
        $jadwal  = $query->paginate($perPage)->withQueryString();

        $hariIni       = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = JadwalPiketGuru::where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->first();

        $logBulanIni = LogPiket::where('guru_id', $guruId)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->orderByDesc('tanggal')
            ->get();

        $rekapBulanIni = [
            'hadir' => $logBulanIni->whereNotNull('masuk_pada')->count(),
            'total' => $logBulanIni->count(),
        ];

        return response()->json([
            'belum_checkin'  => false,
            'jadwal'         => $jadwal,
            'jadwal_hari_ini'=> $jadwalHariIni,
            'log_bulan_ini'  => $logBulanIni,
            'rekap_bulan_ini'=> $rekapBulanIni,
        ]);
    }

    /**
     * GET /api/piket/jadwal/{jadwal}
     *
     * Detail jadwal piket beserta riwayat log.
     *
     * Query params:
     *   - per_page (optional, default 10)
     */
    public function show(Request $request, JadwalPiketGuru $jadwal): JsonResponse
    {
        $guruId = $this->resolveActiveGuruId();

        if (! $guruId) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk melihat detail jadwal.',
            ], 403);
        }

        if ($jadwal->guru_id !== $guruId) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak mengakses jadwal ini.',
            ], 403);
        }

        $jadwal->load('tahunAjaran');

        $perPage    = $request->get('per_page', 10);
        $riwayatLog = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', '>=', now()->subMonths(3))
            ->orderByDesc('tanggal')
            ->paginate($perPage);

        return response()->json([
            'jadwal'      => $jadwal,
            'riwayat_log' => $riwayatLog,
        ]);
    }
}