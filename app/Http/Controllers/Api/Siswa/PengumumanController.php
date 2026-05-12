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
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pengumuman::dipublikasikan()
            ->whereIn('target_role', ['siswa', 'semua']);

        if ($request->filled('cari')) {
            $keyword = '%' . str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $request->cari) . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', $keyword)
                  ->orWhere('isi', 'like', $keyword);
            });
        }

        $pengumuman = $query->orderByDesc('dipublikasikan_pada')
            ->paginate(15)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data'    => $pengumuman,
        ]);
    }

    /**
     * GET /api/siswa/pengumuman/{pengumuman}
     */
    public function show(Pengumuman $pengumuman): JsonResponse
    {
        $bolehDiakses = $pengumuman->dipublikasikan_pada !== null
            && in_array($pengumuman->target_role, ['siswa', 'semua']);

        if (! $bolehDiakses) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pengumuman,
        ]);
    }
}