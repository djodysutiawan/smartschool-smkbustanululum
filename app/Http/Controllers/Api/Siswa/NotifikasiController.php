<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/notifikasi
     * Daftar notifikasi milik siswa, terbaru di atas.
     *
     * Query params:
     *   - status    (string) : 'belum_dibaca' | 'dibaca'
     *   - per_page  (int)    : default 20, max 50
     */
    public function index(Request $request): JsonResponse
    {
        $user        = Auth::user();
        $status      = $request->input('status');
        $statusValid = ['belum_dibaca', 'dibaca'];

        $query = Notifikasi::where('pengguna_id', $user->id);

        if (in_array($status, $statusValid, true)) {
            $status === 'belum_dibaca'
                ? $query->belumDibaca()
                : $query->sudahDibaca();
        }

        $perPage      = min((int) ($request->per_page ?? 20), 50);
        $notifikasis  = $query
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();

        // Hitung unread dari keseluruhan (bukan subset filter)
        $unread = Notifikasi::where('pengguna_id', $user->id)
            ->belumDibaca()
            ->count();

        return response()->json([
            'success' => true,
            'data'    => [
                'notifikasi'  => $notifikasis->map(fn ($n) => $this->formatNotifikasi($n)),
                'unread'      => $unread,
                'jenis_list'  => Notifikasi::JENIS_VALID,
                'meta'        => [
                    'current_page' => $notifikasis->currentPage(),
                    'last_page'    => $notifikasis->lastPage(),
                    'per_page'     => $notifikasis->perPage(),
                    'total'        => $notifikasis->total(),
                ],
            ],
        ]);
    }

    // ── Show ───────────────────────────────────────────────────────────────────

    /**
     * GET /api/siswa/notifikasi/{notifikasi}
     * Detail notifikasi & otomatis tandai dibaca.
     */
    public function show(Notifikasi $notifikasi): JsonResponse
    {
        abort_if((int) $notifikasi->pengguna_id !== (int) Auth::id(), 403);

        $notifikasi->tandaiDibaca();

        return response()->json([
            'success' => true,
            'data'    => ['notifikasi' => $this->formatNotifikasi($notifikasi)],
        ]);
    }

    // ── Mark Read ──────────────────────────────────────────────────────────────

    /**
     * PATCH /api/siswa/notifikasi/{notifikasi}/read
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Notifikasi $notifikasi): JsonResponse
    {
        abort_if((int) $notifikasi->pengguna_id !== (int) Auth::id(), 403);

        $notifikasi->tandaiDibaca();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi telah ditandai sebagai dibaca.',
            'data'    => ['notifikasi' => $this->formatNotifikasi($notifikasi)],
        ]);
    }

    // ── Mark All Read ──────────────────────────────────────────────────────────

    /**
     * PATCH /api/siswa/notifikasi/read-all
     * Tandai semua notifikasi milik user sebagai sudah dibaca.
     */
    public function markAllRead(): JsonResponse
    {
        $query = Notifikasi::where('pengguna_id', Auth::id())->belumDibaca();

        $jumlah = 0;
        if ($query->exists()) {
            $jumlah = $query->count();
            $query->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Semua notifikasi ({$jumlah}) telah ditandai sebagai dibaca.",
        ]);
    }

    // ── Destroy ────────────────────────────────────────────────────────────────

    /**
     * DELETE /api/siswa/notifikasi/{notifikasi}
     * Hapus notifikasi milik user.
     */
    public function destroy(Notifikasi $notifikasi): JsonResponse
    {
        abort_if((int) $notifikasi->pengguna_id !== (int) Auth::id(), 403);

        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.',
        ]);
    }

    // ── Helper ─────────────────────────────────────────────────────────────────

    private function formatNotifikasi(Notifikasi $n): array
    {
        return [
            'id'           => $n->id,
            'judul'        => $n->judul,
            'pesan'        => $n->pesan,
            'jenis'        => $n->jenis,
            'sudah_dibaca' => (bool) $n->sudah_dibaca,
            'dibaca_pada'  => $n->dibaca_pada?->toIso8601String(),
            'created_at'   => $n->created_at?->toIso8601String(),
            'data'         => $n->data ?? null, // payload tambahan (JSON)
        ];
    }
}