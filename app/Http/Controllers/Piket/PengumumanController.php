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
 * Batasan akses (berlaku di index DAN show):
 *  1. Sudah dipublikasikan (dipublikasikan_pada NOT NULL dan <= now())
 *  2. Target role: 'semua' atau 'guru_piket'
 *  3. Belum kadaluarsa (kadaluarsa_pada NULL atau masih di masa depan)
 *
 * Semua filter di atas di-compose via scope Pengumuman::untukPiket()
 * agar tidak ada inkonsistensi antara index dan show.
 *
 * Views: resources/views/piket/pengumuman/
 */
class PengumumanController extends Controller
{
    private const VIEW_PREFIX  = 'piket.pengumuman.';
    private const SIDEBAR_LIMIT = 5;

    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * Daftar pengumuman yang relevan dan masih berlaku untuk guru piket.
     *
     * Urutan: pinned dulu → terbaru (via scopeUrutan).
     * Pencarian: judul LIKE atau isi LIKE jika ada query 'search'.
     *
     * FIX: Gunakan scope untukPiket() agar kondisi filter konsisten dengan show().
     * Versi sebelumnya menuliskan kondisi filter secara manual di sini sehingga
     * berbeda dengan kondisi di show() dan rentan drift ketika salah satu diubah.
     */
    public function index(Request $request): View
    {
        $query = Pengumuman::with('dibuatOleh')
            ->untukPiket()
            ->urutan();

        // Filter pencarian — hanya diaplikasikan jika ada keyword
        if ($request->filled('search')) {
            // trim() untuk menghapus spasi terdepan/terbelakang dari input user
            $keyword = trim($request->string('search'));

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', '%' . $keyword . '%')
                  ->orWhere('isi', 'like', '%' . $keyword . '%');
            });
        }

        $pengumuman = $query->paginate(15)->withQueryString();

        return view(self::VIEW_PREFIX . 'index', compact('pengumuman'));
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    /**
     * Detail satu pengumuman.
     *
     * Guard: semua kondisi dari scope untukPiket() harus terpenuhi.
     * Jika tidak → 404 (tidak membocorkan info pengumuman yang ada tapi
     * belum/tidak boleh ditampilkan).
     *
     * FIX versi sebelumnya:
     *  1. Hanya cek dipublikasikan_pada !== null, tidak cek <= now()
     *     → pengumuman terjadwal masa depan bisa diakses via URL langsung.
     *  2. Kondisi guard berbeda dari index → inkonsistensi akses.
     *  3. abort_if(null !== null && null->isPast()) rentan logical error
     *     pada PHP versi tertentu jika short-circuit berubah semantik.
     *
     * FIX sekarang: re-query dengan scope yang sama persis dengan index()
     * menggunakan findOrFail agar auto-404 jika tidak lolos semua kondisi.
     */
    public function show(int $id): View
    {
        /**
         * Re-query dengan scope untukPiket() untuk memastikan pengumuman
         * yang diakses memenuhi semua syarat yang sama dengan index().
         * Ini adalah pola "scope-guarded show" yang aman dan konsisten:
         * jika suatu pengumuman tidak muncul di index, ia juga tidak bisa
         * diakses di show — tidak ada celah bypass via URL langsung.
         */
        $pengumuman = Pengumuman::untukPiket()
            ->where('id', $id)
            ->firstOrFail();

        $pengumuman->load('dibuatOleh');

        // Sidebar: pengumuman lain yang masih aktif (kecuali yang sedang dibuka)
        // Gunakan scope yang sama agar sidebar konsisten dengan daftar utama.
        $pengumumanLain = Pengumuman::untukPiket()
            ->urutan()
            ->where('id', '!=', $pengumuman->id)
            ->limit(self::SIDEBAR_LIMIT)
            ->get(['id', 'judul', 'dipublikasikan_pada', 'dipinned']); // select minimal

        return view(self::VIEW_PREFIX . 'show', compact('pengumuman', 'pengumumanLain'));
    }
}