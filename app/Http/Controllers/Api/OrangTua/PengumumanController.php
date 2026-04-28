<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * GET /api/ortu/pengumuman
     *
     * Daftar pengumuman untuk orang_tua atau semua role.
     * Hanya yang sudah dipublikasikan dan belum kadaluarsa.
     *
     * Query params:
     *   - cari     (optional) pencarian judul
     *   - per_page (optional, default 15)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>=', now());
            });

        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }

        $perPage    = $request->get('per_page', 15);
        $pengumuman = $query
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'pengumuman' => $pengumuman,
        ]);
    }

    /**
     * GET /api/ortu/pengumuman/{pengumuman}
     *
     * Detail pengumuman beserta 5 pengumuman terkait terbaru.
     */
    public function show(Pengumuman $pengumuman): JsonResponse
    {
        abort_if(
            ! in_array($pengumuman->target_role, ['orang_tua', 'semua'])
            || ! $pengumuman->dipublikasikan,
            403,
            'Pengumuman ini tidak tersedia untuk Anda.'
        );

        $terkait = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where('id', '!=', $pengumuman->id)
            ->orderByDesc('dipublikasikan_pada')
            ->limit(5)
            ->get();

        return response()->json([
            'pengumuman' => $pengumuman,
            'terkait'    => $terkait,
        ]);
    }
}