<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\Guru;
use App\Models\JadwalPiketGuru;
use App\Models\LogPiket;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogPiketController extends Controller
{
    use PiketActiveGuru;

    /**
     * GET /api/piket/log/checkin
     *
     * Data halaman check-in: guru terjadwal, semua guru, log hari ini.
     */
    public function checkin(): JsonResponse
    {
        $hariIni = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));

        $guruTerjadwal = JadwalPiketGuru::with('guru')
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->get()
            ->pluck('guru')
            ->filter()
            ->unique('id')
            ->values();

        $semuaGuru = Guru::aktif()->orderBy('nama_lengkap')->get();

        $logHariIni = LogPiket::with('guru')
            ->whereDate('tanggal', today())
            ->orderByDesc('masuk_pada')
            ->get();

        $logAktif = $logHariIni->whereNull('keluar_pada')->values();

        $riwayatTerakhir = LogPiket::with('guru')
            ->whereDate('tanggal', '>=', now()->subDays(7))
            ->orderByDesc('tanggal')
            ->orderByDesc('masuk_pada')
            ->get();

        return response()->json([
            'guru_terjadwal'   => $guruTerjadwal,
            'semua_guru'       => $semuaGuru,
            'log_hari_ini'     => $logHariIni,
            'log_aktif'        => $logAktif,
            'riwayat_terakhir' => $riwayatTerakhir,
            'hari_ini'         => $hariIni,
        ]);
    }

    /**
     * POST /api/piket/log/checkin
     *
     * Proses check-in guru piket.
     *
     * Body (JSON):
     * {
     *   "guru_id": 1,
     *   "shift": "pagi",       // opsional: pagi|siang|sore
     *   "catatan": "..."       // opsional
     * }
     */
    public function doCheckin(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'guru_id' => ['required', 'exists:guru,id'],
            'catatan' => ['nullable', 'string', 'max:500'],
            'shift'   => ['nullable', 'string', 'in:pagi,siang,sore'],
        ], [
            'guru_id.required' => 'Pilih nama guru yang akan check-in.',
            'guru_id.exists'   => 'Guru tidak ditemukan.',
        ]);

        $guruId  = $validated['guru_id'];
        $hariIni = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));

        $sudahAktif = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', today())
            ->whereNull('keluar_pada')
            ->exists();

        if ($sudahAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Guru ini masih aktif piket dan belum melakukan check-out.',
            ], 422);
        }

        $jadwal = JadwalPiketGuru::where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->first();

        $shift = $validated['shift'] ?? $this->tentukanShift($jadwal?->jam_mulai);

        $log = LogPiket::create([
            'guru_id'              => $guruId,
            'jadwal_piket_guru_id' => $jadwal?->id,
            'pengguna_id'          => Auth::id(),
            'tanggal'              => today(),
            'masuk_pada'           => now(),
            'keluar_pada'          => null,
            'shift'                => $shift,
            'catatan'              => $validated['catatan'] ?? null,
        ]);

        $namaGuru = Guru::find($guruId)?->nama_lengkap ?? 'Guru';

        return response()->json([
            'success' => true,
            'message' => "{$namaGuru} berhasil check-in pukul " . now()->format('H:i') . '.',
            'log'     => $log->load('guru'),
        ], 201);
    }

    /**
     * POST /api/piket/log/{log}/checkout
     *
     * Proses check-out guru piket.
     *
     * Body (JSON):
     * {
     *   "catatan_keluar": "..."  // opsional
     * }
     */
    public function checkout(Request $request, LogPiket $log): JsonResponse
    {
        if (! $log->masuk_pada) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat checkout: belum ada data check-in.',
            ], 422);
        }

        if ($log->keluar_pada) {
            return response()->json([
                'success' => false,
                'message' => 'Log ini sudah melakukan check-out sebelumnya.',
            ], 422);
        }

        if (! $log->tanggal->isToday()) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya log hari ini yang bisa di-checkout.',
            ], 422);
        }

        $validated = $request->validate([
            'catatan_keluar' => ['nullable', 'string', 'max:500'],
        ]);

        $log->checkOut();

        if (! empty($validated['catatan_keluar'])) {
            $log->update([
                'catatan' => ($log->catatan ? $log->catatan . ' | ' : '') . $validated['catatan_keluar'],
            ]);
        }

        $namaGuru = $log->guru?->nama_lengkap ?? 'Guru';

        return response()->json([
            'success' => true,
            'message' => "{$namaGuru} berhasil check-out pukul " . now()->format('H:i') . '.',
            'log'     => $log->fresh('guru'),
        ]);
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function tentukanShift(?string $jamMulai): string
    {
        if (! $jamMulai) return 'pagi';
        $jam = (int) Carbon::createFromFormat('H:i', $jamMulai)->format('H');
        return $jam < 12 ? 'pagi' : 'siang';
    }
}