<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Daftar pengumuman yang dapat dilihat orang tua.
     *
     * Aturan:
     *  - Hanya yang sudah dipublikasikan (dipublikasikan_pada NOT NULL)
     *  - Target role 'orang_tua' atau 'semua'
     *  - Belum kadaluarsa (kadaluarsa_pada NULL atau > now())
     *  - Pinned di atas, lalu terbaru
     */
    public function index(Request $request)
    {
        $query = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->with('dibuatOleh');

        if ($request->filled('cari')) {
            $cari = $request->string('cari')->trim()->value();
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('isi', 'like', "%{$cari}%");
            });
        }

        $pengumuman = $query
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->paginate(10)
            ->withQueryString();

        return view('orangtua.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Detail satu pengumuman.
     *
     * Guard:
     *  - Harus sudah dipublikasikan
     *  - Target role sesuai
     *  - Belum kadaluarsa (tetap tampilkan tapi beri penanda)
     */
    public function show(Pengumuman $pengumuman)
    {
        // Pastikan sudah dipublikasikan dan target role cocok
        abort_if(
            $pengumuman->dipublikasikan_pada === null,
            404
        );

        abort_if(
            ! in_array($pengumuman->target_role, ['orang_tua', 'semua']),
            403
        );

        // Pengumuman terkait (bukan yang sedang dibuka, sama target, belum kadaluarsa)
        $terkait = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->where('id', '!=', $pengumuman->id)
            ->with('dibuatOleh')
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->limit(5)
            ->get();

        return view('orangtua.pengumuman.show', compact('pengumuman', 'terkait'));
    }
}