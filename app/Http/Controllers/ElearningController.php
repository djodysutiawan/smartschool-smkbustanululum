<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\MataPelajaran;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;

class ElearningController extends Controller
{
    public function index(Request $request)
    {
        $profil = ProfilSekolah::instance();

        $query = Materi::dipublikasikan()
            ->with(['guru', 'mataPelajaran', 'kelas'])
            ->orderByDesc('dipublikasikan_pada');

        // Filter jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter mata pelajaran
        if ($request->filled('mapel')) {
            $query->where('mata_pelajaran_id', $request->mapel);
        }

        // Search
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
            });
        }

        $materi = $query->paginate(12)->withQueryString();

        // Untuk filter dropdown
        $mapelList = MataPelajaran::whereHas('materi', fn($q) => $q->where('dipublikasikan', true))
            ->orderBy('nama_mapel')
            ->get();

        // Stats
        $stats = [
            'total'   => Materi::dipublikasikan()->count(),
            'video'   => Materi::dipublikasikan()->where('jenis', 'video')->count(),
            'dokumen' => Materi::dipublikasikan()->whereIn('jenis', ['pdf', 'dokumen'])->count(),
            'link'    => Materi::dipublikasikan()->where('jenis', 'link')->count(),
        ];

        return view('elearning.index', compact('profil', 'materi', 'mapelList', 'stats'));
    }
}