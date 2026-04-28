<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Notifikasi::where('pengguna_id', $userId);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('sudah_dibaca')) {
            $query->where('sudah_dibaca', $request->sudah_dibaca === 'ya');
        }

        $notifikasis = $query->latest()->paginate(20)->withQueryString();

        $unread  = Notifikasi::where('pengguna_id', $userId)->where('sudah_dibaca', false)->count();
        $jenisList = ['info', 'peringatan', 'pelanggaran', 'absensi', 'nilai', 'pengumuman', 'tugas', 'ujian'];

        return view('guru.notifikasi.index', compact('notifikasis', 'unread', 'jenisList'));
    }

    public function show(Notifikasi $notifikasi)
    {
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403, 'Anda tidak memiliki akses ke notifikasi ini.');

        // Tandai otomatis saat dibuka
        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);
        }

        return view('guru.notifikasi.show', compact('notifikasi'));
    }

    public function markRead(Notifikasi $notifikasi)
    {
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403, 'Anda tidak memiliki akses ke notifikasi ini.');

        $notifikasi->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllRead()
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true, 'dibaca_pada' => now()]);

        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    public function destroy(Notifikasi $notifikasi)
    {
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403, 'Anda tidak memiliki akses ke notifikasi ini.');

        $notifikasi->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}