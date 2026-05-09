<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * NotifikasiController (Piket)
 *
 * Guru piket hanya bisa melihat dan mengelola notifikasi MILIK SENDIRI.
 * Tidak ada akses ke notifikasi pengguna lain — berbeda dengan Admin
 * yang bisa melihat semua notifikasi semua pengguna.
 *
 * Piket TIDAK bisa:
 *  - Membuat notifikasi (hanya admin)
 *  - Melihat notifikasi pengguna lain
 *  - Bulk delete semua notifikasi (hanya satu per satu atau semua milik sendiri)
 *
 * Views: resources/views/piket/notifikasi/
 */
class NotifikasiController extends Controller
{
    private const VIEW_PREFIX = 'piket.notifikasi.';

    /**
     * Daftar jenis notifikasi — disinkronkan dengan validasi Admin\NotifikasiController
     * agar filter tidak pernah menerima nilai yang tidak ada di database.
     */
    private const JENIS_LIST = [
        'info', 'peringatan', 'pelanggaran',
        'absensi', 'nilai', 'pengumuman', 'tugas', 'ujian',
    ];

    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * Daftar notifikasi milik piket yang sedang login.
     *
     * Filter:
     *  - jenis      → filter per kategori notifikasi
     *  - sudah_dibaca → 'ya' / 'tidak'
     */
    public function index(Request $request): View
    {
        $userId = Auth::id();

        $query = Notifikasi::where('pengguna_id', $userId);

        if ($request->filled('jenis') && in_array($request->jenis, self::JENIS_LIST, true)) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('sudah_dibaca')) {
            $query->where('sudah_dibaca', $request->sudah_dibaca === 'ya');
        }

        $notifikasi  = $query->latest()->paginate(20)->withQueryString();
        $unreadCount = Notifikasi::where('pengguna_id', $userId)
            ->where('sudah_dibaca', false)
            ->count();

        $jenisList = self::JENIS_LIST;

        return view(self::VIEW_PREFIX . 'index', compact(
            'notifikasi',
            'unreadCount',
            'jenisList',
        ));
    }

    // ── SHOW ─────────────────────────────────────────────────────────────────

    /**
     * Tampilkan detail satu notifikasi dan tandai sebagai sudah dibaca.
     *
     * Otomatis tandai dibaca saat halaman dibuka — konsisten dengan
     * perilaku aplikasi notifikasi pada umumnya.
     */
    public function show(Notifikasi $notifikasi): View
    {
        $this->authorizeOwnership($notifikasi);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update([
                'sudah_dibaca'    => true,
                'dibaca_pada'     => now(),
            ]);
        }

        return view(self::VIEW_PREFIX . 'show', compact('notifikasi'));
    }

    // ── MARK READ (single) ────────────────────────────────────────────────────

    /**
     * Tandai satu notifikasi sebagai sudah dibaca (tanpa membuka halaman detail).
     *
     * Dipakai untuk aksi cepat dari daftar (misalnya tombol centang di baris tabel).
     * Idempoten: tidak error jika notifikasi sudah dibaca sebelumnya.
     */
    public function markRead(Notifikasi $notifikasi): RedirectResponse
    {
        $this->authorizeOwnership($notifikasi);

        if (! $notifikasi->sudah_dibaca) {
            $notifikasi->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    // ── MARK ALL READ ─────────────────────────────────────────────────────────

    /**
     * Tandai SEMUA notifikasi milik piket ini sebagai sudah dibaca.
     *
     * Hanya memperbarui yang belum dibaca agar query tidak percuma.
     */
    public function markAllRead(): RedirectResponse
    {
        $updated = Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);

        $pesan = $updated > 0
            ? "{$updated} notifikasi ditandai sudah dibaca."
            : 'Tidak ada notifikasi yang belum dibaca.';

        return back()->with('success', $pesan);
    }

    // ── DESTROY (single) ──────────────────────────────────────────────────────

    /**
     * Hapus satu notifikasi milik sendiri.
     */
    public function destroy(Notifikasi $notifikasi): RedirectResponse
    {
        $this->authorizeOwnership($notifikasi);

        $notifikasi->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    // ── DESTROY ALL READ ──────────────────────────────────────────────────────

    /**
     * Hapus semua notifikasi yang sudah dibaca milik piket ini.
     *
     * Berguna untuk "bersihkan kotak masuk" tanpa harus hapus satu per satu.
     * Notifikasi yang belum dibaca dibiarkan agar tidak ada yang terlewat.
     */
    public function destroyAllRead(): RedirectResponse
    {
        $deleted = Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', true)
            ->delete();

        $pesan = $deleted > 0
            ? "{$deleted} notifikasi yang sudah dibaca berhasil dihapus."
            : 'Tidak ada notifikasi yang sudah dibaca untuk dihapus.';

        return back()->with('success', $pesan);
    }

    // ── HELPER ────────────────────────────────────────────────────────────────

    /**
     * Pastikan notifikasi adalah milik pengguna yang sedang login.
     * Abort 403 jika bukan — piket tidak boleh mengakses notifikasi orang lain.
     */
    private function authorizeOwnership(Notifikasi $notifikasi): void
    {
        abort_unless(
            $notifikasi->pengguna_id === Auth::id(),
            403,
            'Anda tidak berhak mengakses notifikasi ini.'
        );
    }
}