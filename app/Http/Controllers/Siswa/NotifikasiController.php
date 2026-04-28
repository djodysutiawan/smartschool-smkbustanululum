<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Daftar notifikasi milik siswa, terbaru di atas.
     *
     * Query string:
     *   ?status=belum_dibaca  → hanya yang belum dibaca
     *   ?status=dibaca        → hanya yang sudah dibaca
     *   (kosong)              → semua
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Notifikasi::where('pengguna_id', $user->id);

        // Filter status — sesuaikan dengan nilai tab di view (belum_dibaca / dibaca)
        if ($request->filled('status')) {
            if ($request->status === 'belum_dibaca') {
                $query->where('sudah_dibaca', false);
            } elseif ($request->status === 'dibaca') {
                $query->where('sudah_dibaca', true);
            }
        }

        $notifikasis = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        $unread = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        $jenisList = ['info', 'peringatan', 'nilai', 'absensi', 'tugas', 'pengumuman'];

        return view('siswa.notifikasi.index', compact('notifikasis', 'unread', 'jenisList'));
    }

    /**
     * Tandai notifikasi sebagai dibaca dan tampilkan detail.
     */
    public function show(Notifikasi $notifikasi)
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        return view('siswa.notifikasi.show', compact('notifikasi'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca (via AJAX / redirect).
     */
    public function markRead(Notifikasi $notifikasi)
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        $notifikasi->update([
            'sudah_dibaca' => true,
            'dibaca_pada'  => now(),
        ]);

        // Dukung AJAX maupun redirect biasa
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Tandai semua notifikasi milik user sebagai sudah dibaca.
     */
    public function markAllRead()
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Hapus notifikasi milik user.
     */
    public function destroy(Notifikasi $notifikasi)
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        $notifikasi->delete();

        return redirect()->route('siswa.notifikasi.index')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }
}