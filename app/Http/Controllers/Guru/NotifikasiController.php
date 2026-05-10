<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $userId = Auth::id();

        $query = Notifikasi::where('pengguna_id', $userId);

        // FIX: Validasi nilai 'jenis' terhadap konstanta model agar tidak bisa
        // di-inject nilai sembarang lewat query string.
        if ($request->filled('jenis') && in_array($request->jenis, Notifikasi::JENIS_VALID, true)) {
            $query->where('jenis', $request->jenis);
        }

        // FIX: Hanya terima nilai 'ya' atau 'tidak'; abaikan nilai lain.
        if ($request->filled('sudah_dibaca') && in_array($request->sudah_dibaca, ['ya', 'tidak'], true)) {
            $query->where('sudah_dibaca', $request->sudah_dibaca === 'ya');
        }

        $notifikasis = $query->latest()->paginate(20)->withQueryString();

        // FIX: Hitung unread secara terpisah (tidak terpengaruh filter) agar
        // angka di stats-strip selalu menggambarkan kondisi nyata, bukan hasil filter.
        $unread = Notifikasi::where('pengguna_id', $userId)
            ->where('sudah_dibaca', false)
            ->count();

        // FIX: Ambil jenisList dari konstanta model sebagai single source of truth.
        // Sebelumnya controller mendefinisikan daftar sendiri (berbeda isi dengan model)
        // sehingga jenis 'pelanggaran' dan 'ujian' ada di filter tapi tidak ada di model
        // dan tidak punya CSS badge class yang valid → broken UI.
        $jenisList = Notifikasi::JENIS_VALID;

        return view('guru.notifikasi.index', compact('notifikasis', 'unread', 'jenisList'));
    }

    // ── Show ───────────────────────────────────────────────────────────────────

    public function show(Notifikasi $notifikasi): View
    {
        // FIX: Gunakan abort_if dengan pesan yang jelas.
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403);

        // FIX: Gunakan method tandaiDibaca() dari model — method ini sudah memiliki
        // guard internal (tidak update jika sudah dibaca), sehingga tidak ada
        // UPDATE query sia-sia dan timestamp dibaca_pada tidak berubah.
        $notifikasi->tandaiDibaca();

        return view('guru.notifikasi.show', compact('notifikasi'));
    }

    // ── Mark Single Read ───────────────────────────────────────────────────────

    public function markRead(Notifikasi $notifikasi): RedirectResponse
    {
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403);

        // FIX: Gunakan tandaiDibaca() — konsisten dengan show() dan model.
        // Sebelumnya: update() dipanggil langsung tanpa guard → selalu hit DB
        // bahkan jika notifikasi sudah dibaca.
        $notifikasi->tandaiDibaca();

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    // ── Mark All Read ──────────────────────────────────────────────────────────

    public function markAllRead(): RedirectResponse
    {
        // FIX: Bulk update dengan dibaca_pada menggunakan now() sudah benar untuk
        // Laravel/MySQL. Hanya update record yang belum dibaca (sudah di-scope).
        // Tidak perlu looping karena jumlah notifikasi per user bisa banyak.
        Notifikasi::where('pengguna_id', Auth::id())
            ->belumDibaca()                          // pakai scope dari model
            ->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);

        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    // ── Destroy ────────────────────────────────────────────────────────────────

    public function destroy(Notifikasi $notifikasi): RedirectResponse
    {
        abort_if($notifikasi->pengguna_id !== Auth::id(), 403);

        $notifikasi->delete();

        // FIX: Jika dihapus dari halaman show, back() akan mengarah ke show yang
        // sudah tidak ada (404). Redirect ke index lebih aman.
        return redirect()->route('guru.notifikasi.index')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }
}