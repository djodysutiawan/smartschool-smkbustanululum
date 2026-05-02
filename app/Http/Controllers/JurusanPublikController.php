<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;

class JurusanPublikController extends Controller
{
    /**
     * Halaman daftar semua jurusan (publik)
     * GET /jurusan
     */
    public function index()
    {
        $profil = ProfilSekolah::instance();

        $jurusan = Jurusan::where('is_published', true)
            ->with(['kompetensi', 'prospekKerja', 'fasilitas'])
            ->orderBy('urutan')
            ->get();

        $stats = [
            'total_jurusan'     => $jurusan->count(),
            'penerimaan_buka'   => $jurusan->where('is_penerimaan_buka', true)->count(),
            'total_kelas_aktif' => $jurusan->sum('jumlah_kelas_aktif'),
            'total_siswa'       => $jurusan->sum('total_siswa'),
        ];

        return view('jurusan.index', compact('profil', 'jurusan', 'stats'));
    }

    /**
     * Halaman detail satu jurusan (publik)
     * GET /jurusan/{slug}
     */
    public function show(string $slug)
    {
        $profil = ProfilSekolah::instance();

        $jurusan = Jurusan::where('slug', $slug)
            ->where('is_published', true)
            ->with(['kompetensi', 'prospekKerja', 'fasilitas', 'kurikulum'])
            ->firstOrFail();

        // Jurusan lain untuk sidebar / rekomendasi (kecuali yang sedang dilihat)
        $jurusanLain = Jurusan::where('is_published', true)
            ->where('id', '!=', $jurusan->id)
            ->with(['kompetensi'])
            ->orderBy('urutan')
            ->limit(3)
            ->get();

        // Kelompokkan kurikulum berdasarkan kelas
        $kurikulumPerKelas = $jurusan->kurikulum
            ->groupBy('kelas')
            ->sortKeys();

        return view('jurusan.show', compact(
            'profil',
            'jurusan',
            'jurusanLain',
            'kurikulumPerKelas',
        ));
    }
}