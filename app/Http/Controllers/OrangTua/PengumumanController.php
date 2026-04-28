<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Daftar pengumuman untuk orang_tua atau semua role.
     * Hanya yang sudah dipublikasikan (dipublikasikan_pada tidak null).
     */
    public function index(Request $request)
    {
        $query = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where(function ($q) {
                // Belum kadaluarsa atau tidak ada batas kadaluarsa
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
     * Detail pengumuman.
     */
    public function show(Pengumuman $pengumuman)
    {
        abort_if(
            ! in_array($pengumuman->target_role, ['orang_tua', 'semua'])
            || ! $pengumuman->dipublikasikan,
            403,
            'Pengumuman ini tidak tersedia untuk Anda.'
        );

        // Pengumuman terkait / terbaru
        $terkait = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where('id', '!=', $pengumuman->id)
            ->orderByDesc('dipublikasikan_pada')
            ->limit(5)
            ->get();

        return view('orangtua.pengumuman.show', compact('pengumuman', 'terkait'));
    }
}