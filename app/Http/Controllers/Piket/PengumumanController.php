<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    /**
     * Daftar pengumuman yang relevan untuk guru piket.
     * Hanya menampilkan pengumuman yang sudah dipublikasikan
     * dan target-nya 'semua' atau 'guru_piket'.
     */
    public function index(Request $request)
    {
        $query = Pengumuman::with('dibuatOleh')
            ->whereNotNull('dipublikasikan_pada')
            ->whereIn('target_role', ['semua', 'guru_piket'])
            ->where(function ($q) {
                // Tampilkan pengumuman yang belum kadaluarsa
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->where('judul', 'like', "%{$s}%")
                ->orWhere('isi', 'like', "%{$s}%"));
        }

        $pengumuman = $query->paginate(15)->withQueryString();

        return view('piket.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Detail satu pengumuman.
     */
    public function show(Pengumuman $pengumuman)
    {
        // Pastikan pengumuman sudah dipublikasikan dan target sesuai
        abort_unless(
            $pengumuman->dipublikasikan_pada &&
            in_array($pengumuman->target_role, ['semua', 'guru_piket']),
            404
        );

        $pengumuman->load('dibuatOleh');

        // Pengumuman terkait (pinned atau terbaru, selain ini)
        $pengumumanLain = Pengumuman::whereNotNull('dipublikasikan_pada')
            ->whereIn('target_role', ['semua', 'guru_piket'])
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->where('id', '!=', $pengumuman->id)
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->take(5)
            ->get();

        return view('piket.pengumuman.show', compact('pengumuman', 'pengumumanLain'));
    }
}