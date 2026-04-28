<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * GET /api/siswa/notifikasi
     * Daftar notifikasi milik siswa.
     * Query: ?status=belum_dibaca|dibaca&per_page=
     */
    public function index(Request $request): JsonResponse
    {
        $user  = Auth::user();
        $query = Notifikasi::where('pengguna_id', $user->id);

        if ($request->filled('status')) {
            if ($request->status === 'belum_dibaca') {
                $query->where('sudah_dibaca', false);
            } elseif ($request->status === 'dibaca') {
                $query->where('sudah_dibaca', true);
            }
        }

        $perPage     = min((int) $request->get('per_page', 20), 50);
        $notifikasis = $query->orderByDesc('created_at')->paginate($perPage);

        $unread = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        return response()->json([
            'success' => true,
            'data'    => [
                'notifikasi' => $notifikasis,
                'unread'     => $unread,
                'jenis_list' => ['info', 'peringatan', 'nilai', 'absensi', 'tugas', 'pengumuman'],
            ],
        ]);
    }

    /**
     * GET /api/siswa/notifikasi/{notifikasi}
     * Detail notifikasi; otomatis ditandai dibaca.
     */
    public function show(Notifikasi $notifikasi): JsonResponse
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => ['notifikasi' => $notifikasi],
        ]);
    }

    /**
     * PATCH /api/siswa/notifikasi/{notifikasi}/read
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Notifikasi $notifikasi): JsonResponse
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        $notifikasi->update([
            'sudah_dibaca' => true,
            'dibaca_pada'  => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi telah ditandai sebagai dibaca.',
        ]);
    }

    /**
     * PATCH /api/siswa/notifikasi/read-all
     * Tandai semua notifikasi milik user sebagai sudah dibaca.
     */
    public function markAllRead(): JsonResponse
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca.',
        ]);
    }

    /**
     * DELETE /api/siswa/notifikasi/{notifikasi}
     * Hapus notifikasi milik user.
     */
    public function destroy(Notifikasi $notifikasi): JsonResponse
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.',
        ]);
    }
}