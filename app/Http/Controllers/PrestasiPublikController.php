<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Prestasi;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;

class PrestasiPublikController extends Controller
{
    /**
     * Halaman daftar prestasi (publik)
     * GET /prestasi
     */
    public function index(Request $request)
    {
        $profil = ProfilSekolah::instance();

        $query = Prestasi::where('is_published', true)
            ->with(['jurusan'])
            ->orderByDesc('tanggal')
            ->orderByDesc('urutan');

        // Filter tingkat
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Filter jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan_id', $request->jurusan);
        }

        $prestasi = $query->paginate(12)->withQueryString();

        // Data untuk filter dropdown
        $tahunList = Prestasi::where('is_published', true)
            ->whereNotNull('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $jurusanList = Jurusan::where('is_published', true)
            ->orderBy('urutan')
            ->get(['id', 'nama', 'singkatan']);

        // Statistik
        $stats = [
            'total'          => Prestasi::where('is_published', true)->count(),
            'nasional'       => Prestasi::where('is_published', true)->whereIn('tingkat', ['nasional', 'internasional'])->count(),
            'provinsi'       => Prestasi::where('is_published', true)->where('tingkat', 'provinsi')->count(),
            'tahun_ini'      => Prestasi::where('is_published', true)->where('tahun', date('Y'))->count(),
        ];

        $tingkatList = [
            'sekolah'       => 'Tingkat Sekolah',
            'kecamatan'     => 'Tingkat Kecamatan',
            'kabupaten'     => 'Tingkat Kabupaten/Kota',
            'provinsi'      => 'Tingkat Provinsi',
            'nasional'      => 'Tingkat Nasional',
            'internasional' => 'Tingkat Internasional',
        ];

        return view('prestasi.index', compact(
            'profil', 'prestasi', 'stats',
            'tahunList', 'jurusanList', 'tingkatList',
        ));
    }
}