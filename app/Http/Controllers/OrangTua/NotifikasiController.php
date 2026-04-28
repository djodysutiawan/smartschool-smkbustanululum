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

        if ($request->filled('status')) {
            $query->where('sudah_dibaca', $request->status === 'dibaca');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $notifikasis = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $unread      = Notifikasi::where('pengguna_id', $user->id)->where('sudah_dibaca', false)->count();
        $jenisList   = ['info', 'peringatan', 'nilai', 'absensi', 'pelanggaran', 'pengumuman'];

        return view('orangtua.notifikasi.index', compact('notifikasis', 'unread', 'jenisList'));
    }

    /**
     * Detail notifikasi — otomatis ditandai sudah dibaca.
     */
    public function show(Notifikasi $notifikasi)
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);
        }

        return view('orangtua.notifikasi.show', compact('notifikasi'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Notifikasi $notifikasi)
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        $notifikasi->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);

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
            ->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Hapus notifikasi.
     */
    public function destroy(Notifikasi $notifikasi)
    {
        $user = Auth::user();
        abort_if($notifikasi->pengguna_id !== $user->id, 403);

        $notifikasi->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}