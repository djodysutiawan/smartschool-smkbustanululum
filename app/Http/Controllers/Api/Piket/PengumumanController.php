<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * GET /api/piket/pengumuman
     *
     * Daftar pengumuman untuk guru piket.
     * Hanya yang sudah dipublikasikan, target 'semua' atau 'guru_piket', belum kadaluarsa.
     *
     * Query params:
     *   - search   (optional) cari di judul atau isi
     *   - per_page (optional, default 15)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pengumuman::with('dibuatOleh')
            ->whereNotNull('dipublikasikan_pada')
            ->whereIn('target_role', ['semua', 'guru_piket'])
            ->where(function ($q) {
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

        $perPage    = $request->get('per_page', 15);
        $pengumuman = $query->paginate($perPage)->withQueryString();

        return response()->json([
            'pengumuman' => $pengumuman,
        ]);
    }

    /**
     * GET /api/piket/pengumuman/{pengumuman}
     *
     * Detail satu pengumuman beserta pengumuman lain yang relevan.
     */
    public function show(Pengumuman $pengumuman): JsonResponse
    {
        if (
            ! $pengumuman->dipublikasikan_pada ||
            ! in_array($pengumuman->target_role, ['semua', 'guru_piket'])
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan.',
            ], 404);
        }

        $pengumuman->load('dibuatOleh');

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

        return response()->json([
            'pengumuman'     => $pengumuman,
            'pengumuman_lain'=> $pengumumanLain,
        ]);
    }
}