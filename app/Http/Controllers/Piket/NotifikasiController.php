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
 * Tidak ada akses ke notifikasi pengguna lain.
 *
 * Piket TIDAK bisa:
 *  - Membuat notifikasi (hanya admin)
 *  - Melihat notifikasi pengguna lain
 */
class NotifikasiController extends Controller
{
    private const VIEW_PREFIX = 'piket.notifikasi.';

    /**
     * Daftar jenis notifikasi — HARUS sinkron dengan Notifikasi::JENIS_VALID di model.
     * Gunakan model sebagai single source of truth untuk validasi.
     *
     * Catatan: 'pelanggaran' dan 'ujian' ada di view tapi tidak di Model::JENIS_VALID.
     * Jika model diperluas, tambahkan di sana terlebih dahulu.
     */
    private function getJenisList(): array
    {
        // Gunakan konstanta dari model agar selalu sinkron.
        // Jika model belum punya konstanta ini, fallback ke array lokal.
        return defined(Notifikasi::class . '::JENIS_VALID')
            ? Notifikasi::JENIS_VALID
            : ['info', 'peringatan', 'nilai', 'absensi', 'tugas', 'pengumuman'];
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * Daftar notifikasi milik piket yang sedang login.
     *
     * Filter:
     *  - jenis        → filter per kategori notifikasi
     *  - sudah_dibaca → 'ya' / 'tidak'
     */
    public function index(Request $request): View
    {
        $userId    = Auth::id();
        $jenisList = $this->getJenisList();

        $query = Notifikasi::where('pengguna_id', $userId);

        // Filter jenis — validasi whitelist agar tidak ada SQL injection via query string
        if ($request->filled('jenis') && in_array($request->jenis, $jenisList, true)) {
            $query->where('jenis', $request->jenis);
        }

        // Filter status baca
        if ($request->filled('sudah_dibaca')) {
            $sudahDibaca = match ($request->sudah_dibaca) {
                'ya'    => true,
                'tidak' => false,
                default => null,
            };
            if ($sudahDibaca !== null) {
                $query->where('sudah_dibaca', $sudahDibaca);
            }
        }

        $notifikasi  = $query->latest()->paginate(20)->withQueryString();

        // Hitung unread tanpa filter agar badge header selalu akurat
        $unreadCount = Notifikasi::where('pengguna_id', $userId)
            ->where('sudah_dibaca', false)
            ->count();

        // Hitung sudah-dibaca untuk tombol "Hapus Semua Sudah Dibaca"
        $readCount = Notifikasi::where('pengguna_id', $userId)
            ->where('sudah_dibaca', true)
            ->count();

        return view(self::VIEW_PREFIX . 'index', compact(
            'notifikasi',
            'unreadCount',
            'readCount',
            'jenisList',
        ));
    }

    // ── SHOW ─────────────────────────────────────────────────────────────────

    /**
     * Tampilkan detail satu notifikasi dan tandai sebagai sudah dibaca.
     * Otomatis tandai dibaca saat halaman dibuka.
     */
    public function show(Notifikasi $notifikasi): View
    {
        $this->authorizeOwnership($notifikasi);

        // Gunakan method model agar logika terpusat dan idempoten
        $notifikasi->tandaiDibaca();

        return view(self::VIEW_PREFIX . 'show', compact('notifikasi'));
    }

    // ── MARK READ (single) ────────────────────────────────────────────────────

    /**
     * Tandai satu notifikasi sebagai sudah dibaca (aksi cepat dari daftar).
     * Idempoten: tidak error jika notifikasi sudah dibaca sebelumnya.
     */
    public function markRead(Notifikasi $notifikasi): RedirectResponse
    {
        $this->authorizeOwnership($notifikasi);

        $notifikasi->tandaiDibaca();

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    // ── MARK ALL READ ─────────────────────────────────────────────────────────

    /**
     * Tandai SEMUA notifikasi milik piket ini sebagai sudah dibaca.
     * Hanya memperbarui yang belum dibaca.
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
     *
     * FIX: Selalu redirect ke index, bukan back().
     * Jika dipanggil dari halaman show, back() akan kembali ke halaman
     * yang sudah tidak ada (404). Redirect ke index adalah perilaku yang benar.
     */
    public function destroy(Notifikasi $notifikasi): RedirectResponse
    {
        $this->authorizeOwnership($notifikasi);

        $notifikasi->delete();

        return redirect()
            ->route('piket.notifikasi.index')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }

    // ── DESTROY ALL READ ──────────────────────────────────────────────────────

    /**
     * Hapus semua notifikasi yang sudah dibaca milik piket ini.
     * Notifikasi belum dibaca dibiarkan agar tidak ada yang terlewat.
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
     * Abort 403 jika bukan.
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