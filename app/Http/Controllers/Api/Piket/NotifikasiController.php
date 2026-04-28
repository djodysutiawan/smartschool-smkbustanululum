<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * GET /api/piket/notifikasi
     *
     * Daftar notifikasi milik user yang login.
     *
     * Query params:
     *   - jenis        (optional)
     *   - sudah_dibaca (optional) ya|tidak
     *   - per_page     (optional, default 20)
     */
    public function index(Request $request): JsonResponse
    {
        $user  = Auth::user();
        $query = Notifikasi::where('pengguna_id', $user->id);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('sudah_dibaca')) {
            $query->where('sudah_dibaca', $request->sudah_dibaca === 'ya');
        }

        $perPage     = $request->get('per_page', 20);
        $notifikasi  = $query->latest()->paginate($perPage)->withQueryString();
        $unreadCount = Notifikasi::where('pengguna_id', $user->id)->where('sudah_dibaca', false)->count();

        $jenisList = ['info', 'peringatan', 'pelanggaran', 'absensi', 'nilai', 'pengumuman', 'tugas', 'ujian'];

        return response()->json([
            'notifikasi'  => $notifikasi,
            'unread_count'=> $unreadCount,
            'jenis_list'  => $jenisList,
        ]);
    }

    /**
     * GET /api/piket/notifikasi/{notifikasi}
     *
     * Detail notifikasi — otomatis ditandai sudah dibaca.
     */
    public function show(Notifikasi $notifikasi): JsonResponse
    {
        $this->authorizeOwnership($notifikasi);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update(['sudah_dibaca' => true]);
        }

        return response()->json([
            'notifikasi' => $notifikasi,
        ]);
    }

    /**
     * PATCH /api/piket/notifikasi/read-all
     *
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllRead(): JsonResponse
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai sudah dibaca.',
        ]);
    }

    /**
     * PATCH /api/piket/notifikasi/{notifikasi}/read
     *
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Notifikasi $notifikasi): JsonResponse
    {
        $this->authorizeOwnership($notifikasi);

        $notifikasi->update(['sudah_dibaca' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil ditandai sebagai sudah dibaca.',
        ]);
    }

    /**
     * DELETE /api/piket/notifikasi/{notifikasi}
     *
     * Hapus notifikasi.
     */
    public function destroy(Notifikasi $notifikasi): JsonResponse
    {
        $this->authorizeOwnership($notifikasi);

        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.',
        ]);
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function authorizeOwnership(Notifikasi $notifikasi): void
    {
        if ($notifikasi->pengguna_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses notifikasi ini.');
        }
    }
}