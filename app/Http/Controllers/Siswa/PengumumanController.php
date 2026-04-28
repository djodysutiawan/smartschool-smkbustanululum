<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Daftar pengumuman yang ditujukan ke siswa atau semua role.
     * Sudah dipublikasikan = dipublikasikan_pada IS NOT NULL.
     */
    public function index(Request $request)
    {
        $query = Pengumuman::dipublikasikan()->untukRole('siswa');

        if ($request->filled('cari')) {
            $keyword = '%' . $request->cari . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', $keyword)
                  ->orWhere('isi',  'like', $keyword);
            });
        }

        $pengumuman = $query->orderByDesc('dipublikasikan_pada')
            ->paginate(15)
            ->withQueryString();

        return view('siswa.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Detail pengumuman — hanya yang sudah dipublikasikan & untuk siswa/semua.
     */
    public function show(Pengumuman $pengumuman)
    {
        abort_if(
            $pengumuman->dipublikasikan_pada === null
            || ! in_array($pengumuman->target_role, ['siswa', 'semua']),
            403,
            'Pengumuman ini tidak tersedia untuk Anda.'
        );

        return view('siswa.pengumuman.show', compact('pengumuman'));
    }
}