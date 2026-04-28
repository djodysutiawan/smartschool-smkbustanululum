<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * GET /api/siswa/pengumuman
     * Daftar pengumuman yang dipublikasikan untuk role siswa.
     * Query: ?cari=&per_page=
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pengumuman::dipublikasikan()->untukRole('siswa');

        if ($request->filled('cari')) {
            $keyword = '%' . $request->cari . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', $keyword)
                  ->orWhere('isi', 'like', $keyword);
            });
        }

        $perPage    = min((int) $request->get('per_page', 15), 50);
        $pengumuman = $query->orderByDesc('dipublikasikan_pada')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => ['pengumuman' => $pengumuman],
        ]);
    }

    /**
     * GET /api/siswa/pengumuman/{pengumuman}
     * Detail pengumuman; hanya yang sudah dipublikasikan & untuk siswa.
     */
    public function show(Pengumuman $pengumuman): JsonResponse
    {
        abort_if(
            $pengumuman->dipublikasikan_pada === null
            || ! in_array($pengumuman->target_role, ['siswa', 'semua']),
            403,
            'Pengumuman ini tidak tersedia untuk Anda.'
        );

        return response()->json([
            'success' => true,
            'data'    => ['pengumuman' => $pengumuman],
        ]);
    }
}