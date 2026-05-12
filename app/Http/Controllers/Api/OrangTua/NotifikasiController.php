<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    private const JENIS_LIST = ['info', 'peringatan', 'nilai', 'absensi', 'pelanggaran', 'pengumuman'];

    /**
     * GET /api/ortu/notifikasi
     * Query: ?status=dibaca|belum &jenis= &page=
     */
    public function index(Request $request): JsonResponse
    {
        $user  = Auth::user();
        $query = Notifikasi::where('pengguna_id', $user->id);

        if ($request->filled('status')) {
            $query->where('sudah_dibaca', $request->status === 'dibaca');
        }

        if ($request->filled('jenis') && in_array($request->jenis, self::JENIS_LIST)) {
            $query->where('jenis', $request->jenis);
        }

        $notifikasis = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $unread = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        return response()->json([
            'success' => true,
            'data'    => [
                'unread'      => $unread,
                'jenis_list'  => self::JENIS_LIST,
                'notifikasi'  => $notifikasis->map(fn ($n) => [
                    'id'           => $n->id,
                    'judul'        => $n->judul,
                    'isi'          => $n->isi,
                    'jenis'        => $n->jenis,
                    'sudah_dibaca' => (bool) $n->sudah_dibaca,
                    'dibaca_pada'  => $n->dibaca_pada?->toIso8601String(),
                    'created_at'   => $n->created_at?->toIso8601String(),
                ])->values(),
                'pagination'  => [
                    'current_page' => $notifikasis->currentPage(),
                    'last_page'    => $notifikasis->lastPage(),
                    'per_page'     => $notifikasis->perPage(),
                    'total'        => $notifikasis->total(),
                ],
            ],
        ]);
    }

    /**
     * GET /api/ortu/notifikasi/{notifikasi}
     * Otomatis ditandai sudah dibaca saat dibuka.
     */
    public function show(Notifikasi $notifikasi): JsonResponse
    {
        if ($notifikasi->pengguna_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'notifikasi' => [
                    'id'           => $notifikasi->id,
                    'judul'        => $notifikasi->judul,
                    'isi'          => $notifikasi->isi,
                    'jenis'        => $notifikasi->jenis,
                    'sudah_dibaca' => true,
                    'dibaca_pada'  => $notifikasi->dibaca_pada?->toIso8601String(),
                    'created_at'   => $notifikasi->created_at?->toIso8601String(),
                ],
            ],
        ]);
    }

    /**
     * PATCH /api/ortu/notifikasi/{notifikasi}/read
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Notifikasi $notifikasi): JsonResponse
    {
        if ($notifikasi->pengguna_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca.',
        ]);
    }

    /**
     * PATCH /api/ortu/notifikasi/read-all
     * Tandai semua notifikasi sebagai sudah dibaca.
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
     * DELETE /api/ortu/notifikasi/{notifikasi}
     */
    public function destroy(Notifikasi $notifikasi): JsonResponse
    {
        if ($notifikasi->pengguna_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.',
        ]);
    }
}