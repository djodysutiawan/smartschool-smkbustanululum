<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────

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

        // FIX #8: Validasi nilai status agar tidak ada SQL injection via
        // query string. Gunakan whitelist, bukan pengecekan string langsung
        // yang bisa di-manipulasi dengan nilai tidak terduga.
        $status = $request->input('status');
        $statusValid = ['belum_dibaca', 'dibaca'];

        $query = Notifikasi::where('pengguna_id', $user->id);

        if (in_array($status, $statusValid, true)) {
            if ($status === 'belum_dibaca') {
                $query->belumDibaca(); // FIX #9: Gunakan scope model, bukan raw where
            } else {
                $query->sudahDibaca(); // FIX #9: Gunakan scope model
            }
        }

        $notifikasis = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        // FIX #10: Hitung unread dengan query terpisah yang di-scope ke
        // keseluruhan notifikasi user (bukan subset hasil filter).
        // Ini penting agar badge unread di tab selalu menampilkan angka benar
        // meskipun filter 'dibaca' sedang aktif.
        $unread = Notifikasi::where('pengguna_id', $user->id)
            ->belumDibaca()
            ->count();

        // FIX #11: Gunakan konstanta model agar tidak ada magic string di controller.
        $jenisList = Notifikasi::JENIS_VALID;

        return view('siswa.notifikasi.index', compact('notifikasis', 'unread', 'jenisList'));
    }

    // ── Show ───────────────────────────────────────────────────────────────────

    /**
     * Tandai notifikasi sebagai dibaca dan tampilkan detail.
     */
    public function show(Notifikasi $notifikasi)
    {
        // FIX #12: Cast kedua sisi ke int untuk perbandingan yang aman dan eksplisit.
        abort_if((int) $notifikasi->pengguna_id !== (int) Auth::id(), 403);

        // FIX #13: Gunakan method tandaiDibaca() dari model yang sudah ada guard
        // 'sudah_dibaca' di dalamnya — tidak perlu cek ulang di sini.
        $notifikasi->tandaiDibaca();

        return view('siswa.notifikasi.show', compact('notifikasi'));
    }

    // ── Mark Read ──────────────────────────────────────────────────────────────

    /**
     * Tandai satu notifikasi sebagai sudah dibaca (via AJAX / redirect).
     */
    public function markRead(Notifikasi $notifikasi)
    {
        abort_if((int) $notifikasi->pengguna_id !== (int) Auth::id(), 403);

        // FIX #14: Gunakan method model yang sudah ada guard di dalamnya.
        $notifikasi->tandaiDibaca();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        // FIX #15: Jika tidak ada "back" yang valid (misal direct URL access),
        // redirect ke index sebagai fallback aman, bukan hanya back().
        return redirect()
            ->back(fallback: route('siswa.notifikasi.index'))
            ->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
    }

    // ── Mark All Read ──────────────────────────────────────────────────────────

    /**
     * Tandai semua notifikasi milik user sebagai sudah dibaca.
     */
    public function markAllRead()
    {
        // FIX #16: Gunakan scope belumDibaca() dari model.
        // Tambahkan ->exists() check sebelum bulk update agar tidak fire
        // UPDATE kosong yang tidak perlu (minor optimization).
        $query = Notifikasi::where('pengguna_id', Auth::id())->belumDibaca();

        if ($query->exists()) {
            // FIX #17: now() dalam bulk update menghasilkan satu timestamp yang sama
            // untuk semua record — ini intentional dan didokumentasikan.
            // Jika perlu timestamp berbeda per-record, gunakan loop + tandaiDibaca().
            $query->update([
                'sudah_dibaca' => true,
                'dibaca_pada'  => now(),
            ]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    // ── Destroy ────────────────────────────────────────────────────────────────

    /**
     * Hapus notifikasi milik user.
     */
    public function destroy(Notifikasi $notifikasi)
    {
        abort_if((int) $notifikasi->pengguna_id !== (int) Auth::id(), 403);

        $notifikasi->delete();

        // FIX #18: Preserve query string (filter status) saat redirect setelah hapus
        // agar user tidak kehilangan posisi filter yang sedang aktif.
        // Ambil status dari request sebelum notifikasi dihapus.
        $currentStatus = request()->query('status');

        return redirect()
            ->route('siswa.notifikasi.index', $currentStatus ? ['status' => $currentStatus] : [])
            ->with('success', 'Notifikasi berhasil dihapus.');
    }
}