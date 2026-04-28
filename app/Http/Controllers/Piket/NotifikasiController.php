<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Notifikasi::where('pengguna_id', $user->id);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('sudah_dibaca')) {
            $query->where('sudah_dibaca', $request->sudah_dibaca === 'ya');
        }

        $notifikasi  = $query->latest()->paginate(20)->withQueryString();
        $unreadCount = Notifikasi::where('pengguna_id', $user->id)->where('sudah_dibaca', false)->count();

        // Daftar jenis untuk filter
        $jenisList = ['info', 'peringatan', 'pelanggaran', 'absensi', 'nilai', 'pengumuman', 'tugas', 'ujian'];

        return view('piket.notifikasi.index', compact('notifikasi', 'unreadCount', 'jenisList'));
    }

    // ── SHOW & MARK READ ─────────────────────────────────────────────────────

    public function show(Notifikasi $notifikasi)
    {
        $this->authorizeOwnership($notifikasi);

        // Tandai sebagai sudah dibaca saat dibuka
        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update(['sudah_dibaca' => true]);
        }

        return view('piket.notifikasi.show', compact('notifikasi'));
    }

    // ── MARK ALL READ ─────────────────────────────────────────────────────────

    public function markAllRead()
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }

    // ── MARK READ (single) ───────────────────────────────────────────────────

    public function markRead(Notifikasi $notifikasi)
    {
        $this->authorizeOwnership($notifikasi);

        $notifikasi->update(['sudah_dibaca' => true]);

        return back()->with('success', 'Notifikasi berhasil ditandai sebagai sudah dibaca.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(Notifikasi $notifikasi)
    {
        $this->authorizeOwnership($notifikasi);

        $notifikasi->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function authorizeOwnership(Notifikasi $notifikasi): void
    {
        abort_unless(
            $notifikasi->pengguna_id === Auth::id(),
            403,
            'Anda tidak berhak mengakses notifikasi ini.'
        );
    }
}