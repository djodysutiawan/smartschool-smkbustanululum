<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * PengumumanController (Piket)
 *
 * Guru piket hanya bisa MEMBACA pengumuman — tidak bisa membuat,
 * mengedit, menghapus, atau mempublikasikan (itu wewenang admin).
 *
 * Batasan akses:
 *  - Hanya tampilkan pengumuman yang sudah dipublikasikan
 *  - Hanya tampilkan target_role 'semua' atau 'guru_piket'
 *  - Pengumuman yang sudah kadaluarsa tidak ditampilkan (index)
 *    dan tidak bisa diakses langsung via URL (show) → 404
 *
 * Views: resources/views/piket/pengumuman/
 */
class PengumumanController extends Controller
{
    private const VIEW_PREFIX       = 'piket.pengumuman.';
    private const TARGET_ROLE_PIKET = ['semua', 'guru_piket'];

    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * Daftar pengumuman yang relevan dan masih berlaku untuk guru piket.
     *
     * Urutan tampil:
     *  1. Pengumuman yang di-pin (dipinned = true) paling atas
     *  2. Setelah itu urut terbaru (dipublikasikan_pada DESC)
     */
    public function index(Request $request): View
    {
        $query = Pengumuman::with('dibuatOleh')
            ->whereNotNull('dipublikasikan_pada')
            ->whereIn('target_role', self::TARGET_ROLE_PIKET)
            ->where(function ($q) {
                // Pengumuman yang belum kadaluarsa atau tidak ada batas kadaluarsa
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada');

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('isi', 'like', "%{$keyword}%");
            });
        }

        $pengumuman = $query->paginate(15)->withQueryString();

        return view(self::VIEW_PREFIX . 'index', compact('pengumuman'));
    }

    // ── SHOW ─────────────────────────────────────────────────────────────────

    /**
     * Detail satu pengumuman.
     *
     * Guard (semua harus terpenuhi, jika tidak → 404):
     *  1. Sudah dipublikasikan (dipublikasikan_pada tidak null)
     *  2. Target role sesuai ('semua' atau 'guru_piket')
     *  3. Belum kadaluarsa (kadaluarsa_pada null atau masih di masa depan)
     *
     * Tampilkan juga 5 pengumuman lain yang masih aktif di sidebar
     * agar piket bisa berpindah tanpa harus kembali ke daftar.
     */
    public function show(Pengumuman $pengumuman): View
    {
        // Guard: belum dipublikasikan
        abort_unless(
            $pengumuman->dipublikasikan_pada !== null,
            404,
            'Pengumuman tidak ditemukan.'
        );

        // Guard: target role tidak sesuai
        abort_unless(
            in_array($pengumuman->target_role, self::TARGET_ROLE_PIKET, true),
            404,
            'Pengumuman tidak ditemukan.'
        );

        // Guard: sudah kadaluarsa
        // (berbeda dengan index yang otomatis filter — di sini akses langsung via URL)
        abort_if(
            $pengumuman->kadaluarsa_pada !== null && $pengumuman->kadaluarsa_pada->isPast(),
            404,
            'Pengumuman ini sudah tidak berlaku.'
        );

        $pengumuman->load('dibuatOleh');

        // 5 pengumuman lain yang masih aktif (untuk sidebar / navigasi)
        $pengumumanLain = Pengumuman::whereNotNull('dipublikasikan_pada')
            ->whereIn('target_role', self::TARGET_ROLE_PIKET)
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->where('id', '!=', $pengumuman->id)
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->limit(5)
            ->get();

        return view(self::VIEW_PREFIX . 'show', compact('pengumuman', 'pengumumanLain'));
    }
}