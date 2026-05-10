<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Daftar notifikasi milik orang tua, terbaru di atas.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Notifikasi::where('pengguna_id', $user->id);

        // Filter status baca
        if ($request->filled('status')) {
            $query->where('sudah_dibaca', $request->status === 'dibaca');
        }

        // Filter jenis
        $jenisList = ['info', 'peringatan', 'nilai', 'absensi', 'pelanggaran', 'pengumuman'];
        if ($request->filled('jenis') && in_array($request->jenis, $jenisList)) {
            $query->where('jenis', $request->jenis);
        }

        $notifikasis = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $unread = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        return view('orangtua.notifikasi.index', compact('notifikasis', 'unread', 'jenisList'));
    }

    /**
     * Detail notifikasi — otomatis ditandai sudah dibaca.
     */
    public function show(Notifikasi $notifikasi)
    {
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        return view('orangtua.notifikasi.show', compact('notifikasi'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca (AJAX-friendly).
     */
    public function markRead(Notifikasi $notifikasi)
    {
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllRead()
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Hapus satu notifikasi.
     */
    public function destroy(Notifikasi $notifikasi)
    {
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403);

        $notifikasi->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}