<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::whereNotNull('dipublikasikan_pada')
            ->where(fn ($q) =>
                $q->whereNull('kadaluarsa_pada')->orWhere('kadaluarsa_pada', '>', now())
            )
            ->where(fn ($q) =>
                $q->where('target_role', 'semua')->orWhere('target_role', 'guru')
            )
            ->latest('dipublikasikan_pada');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $pengumuman = $query->paginate(15)->withQueryString();

        return view('guru.pengumuman.index', compact('pengumuman'));
    }

    public function show(Pengumuman $pengumuman)
    {
        // Pastikan pengumuman sudah dipublikasikan dan ditujukan ke guru
        abort_if(! $pengumuman->dipublikasikan_pada, 404);
        abort_unless(
            in_array($pengumuman->target_role, ['semua', 'guru']),
            403,
            'Pengumuman ini tidak ditujukan untuk Anda.'
        );

        $pengumuman->load('dibuatOleh');

        return view('guru.pengumuman.show', compact('pengumuman'));
    }
}