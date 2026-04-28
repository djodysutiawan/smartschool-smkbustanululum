<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * GET /api/ortu/notifikasi
     *
     * Daftar notifikasi milik orang tua, terbaru di atas.
     *
     * Query params:
     *   - status   (optional) dibaca|belum
     *   - jenis    (optional) info|peringatan|nilai|absensi|pelanggaran|pengumuman
     *   - per_page (optional, default 20)
     */
    public function index(Request $request): JsonResponse
    {
        $user  = Auth::user();
        $query = Notifikasi::where('pengguna_id', $user->id);

        if ($request->filled('status')) {
            $query->where('sudah_dibaca', $request->status === 'dibaca');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $perPage     = $request->get('per_page', 20);
        $notifikasis = $query->orderByDesc('created_at')->paginate($perPage)->withQueryString();

        $unread    = Notifikasi::where('pengguna_id', $user->id)->where('sudah_dibaca', false)->count();
        $jenisList = ['info', 'peringatan', 'nilai', 'absensi', 'pelanggaran', 'pengumuman'];

        return response()->json([
            'notifikasi' => $notifikasis,
            'unread'     => $unread,
            'jenis_list' => $jenisList,
        ]);
    }

    /**
     * GET /api/ortu/notifikasi/{notifikasi}
     *
     * Detail notifikasi — otomatis ditandai sudah dibaca.
     */
    public function show(Notifikasi $notifikasi): JsonResponse
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);
        }

        return response()->json([
            'notifikasi' => $notifikasi,
        ]);
    }

    /**
     * PATCH /api/ortu/notifikasi/{notifikasi}/read
     *
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Notifikasi $notifikasi): JsonResponse
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        $notifikasi->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca.',
        ]);
    }

    /**
     * PATCH /api/ortu/notifikasi/read-all
     *
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllRead(): JsonResponse
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca.',
        ]);
    }

    /**
     * DELETE /api/ortu/notifikasi/{notifikasi}
     *
     * Hapus notifikasi.
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