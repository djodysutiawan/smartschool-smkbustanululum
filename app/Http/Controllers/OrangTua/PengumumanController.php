<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * GET /ortu/pengumuman
     *
     * Daftar pengumuman untuk orang_tua atau semua role.
     * Sudah dipublikasikan = dipublikasikan_pada IS NOT NULL (scope di model).
     * Belum kadaluarsa = kadaluarsa_pada null atau >= sekarang.
     */
    public function index(Request $request)
    {
        $query = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>=', now());
            });

        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }

        // Pinned di atas, lalu terbaru
        $pengumuman = $query
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->paginate(15)
            ->withQueryString();

        return view('orangtua.pengumuman.index', compact('pengumuman'));
    }

    /**
     * GET /ortu/pengumuman/{pengumuman}
     *
     * Detail pengumuman.
     * Accessor `dipublikasikan` di model mengembalikan bool dari dipublikasikan_pada.
     */
    public function show(Pengumuman $pengumuman)
    {
        abort_if(
            ! $pengumuman->dipublikasikan
            || ! in_array($pengumuman->target_role, ['orang_tua', 'semua']),
            403,
            'Pengumuman ini tidak tersedia untuk Anda.'
        );

        // Pengumuman terbaru lainnya untuk sidebar/related
        $terkait = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where('id', '!=', $pengumuman->id)
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>=', now());
            })
            ->orderByDesc('dipublikasikan_pada')
            ->limit(5)
            ->get();

        return view('orangtua.pengumuman.show', compact('pengumuman', 'terkait'));
    }
}