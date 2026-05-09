<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * GET /siswa/pengumuman
     *
     * Daftar pengumuman yang sudah dipublikasikan dan ditujukan ke siswa.
     * Target role yang ditampilkan: 'siswa' dan 'semua'.
     */
    public function index(Request $request)
    {
        $query = Pengumuman::dipublikasikan()
            ->whereIn('target_role', ['siswa', 'semua']);

        if ($request->filled('cari')) {
            // Sanitasi keyword: hilangkan karakter LIKE wildcard dari user input
            $keyword = '%' . str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $request->cari) . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', $keyword)
                  ->orWhere('isi', 'like', $keyword);
            });
        }

        $pengumuman = $query->orderByDesc('dipublikasikan_pada')
            ->paginate(15)
            ->withQueryString();

        return view('siswa.pengumuman.index', compact('pengumuman'));
    }

    /**
     * GET /siswa/pengumuman/{pengumuman}
     *
     * Detail pengumuman — hanya yang sudah dipublikasikan dan untuk siswa/semua.
     */
    public function show(Pengumuman $pengumuman)
    {
        // Pastikan pengumuman sudah dipublikasikan dan ditujukan ke siswa.
        // Menggunakan scope yang sama dengan index() agar konsisten.
        $bolehDiakses = $pengumuman->dipublikasikan_pada !== null
            && in_array($pengumuman->target_role, ['siswa', 'semua']);

        abort_if(! $bolehDiakses, 404); // 404 lebih aman dari 403 agar tidak membocorkan eksistensi data

        return view('siswa.pengumuman.show', compact('pengumuman'));
    }
}