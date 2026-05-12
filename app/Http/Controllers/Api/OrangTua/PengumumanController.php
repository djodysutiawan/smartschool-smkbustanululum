<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // FIX (P1009): tambah import Str agar \Str::limit() dikenali

class PengumumanController extends Controller
{
    /**
     * GET /api/ortu/pengumuman
     * Query: ?cari= &page=
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->with('dibuatOleh');

        if ($request->filled('cari')) {
            $cari = $request->string('cari')->trim()->value();
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('isi', 'like', "%{$cari}%");
            });
        }

        $pengumuman = $query
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data'    => [
                'pengumuman' => $pengumuman->map(fn ($p) => [
                    'id'                  => $p->id,
                    'judul'               => $p->judul,
                    // FIX: gunakan Str::limit() (FQCN via import) bukan \Str::limit()
                    'ringkasan'           => $p->ringkasan ?? Str::limit(strip_tags($p->isi), 120),
                    'dipinned'            => (bool) $p->dipinned,
                    'dipublikasikan_pada' => $p->dipublikasikan_pada?->toIso8601String(),
                    'kadaluarsa_pada'     => $p->kadaluarsa_pada?->toIso8601String(),
                    'dibuat_oleh'         => $p->dibuatOleh?->name,
                ])->values(),
                'pagination' => [
                    'current_page' => $pengumuman->currentPage(),
                    'last_page'    => $pengumuman->lastPage(),
                    'per_page'     => $pengumuman->perPage(),
                    'total'        => $pengumuman->total(),
                ],
            ],
        ]);
    }

    /**
     * GET /api/ortu/pengumuman/{pengumuman}
     */
    public function show(Pengumuman $pengumuman): JsonResponse
    {
        if ($pengumuman->dipublikasikan_pada === null) {
            return response()->json(['success' => false, 'message' => 'Pengumuman tidak ditemukan.'], 404);
        }

        if (! in_array($pengumuman->target_role, ['orang_tua', 'semua'])) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses ke pengumuman ini.'], 403);
        }

        $terkait = Pengumuman::dipublikasikan()
            ->untukRole('orang_tua')
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->where('id', '!=', $pengumuman->id)
            ->with('dibuatOleh')
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->limit(5)
            ->get();

        $sudahKadaluarsa = $pengumuman->kadaluarsa_pada !== null
            && $pengumuman->kadaluarsa_pada->isPast();

        return response()->json([
            'success' => true,
            'data'    => [
                'pengumuman' => [
                    'id'                  => $pengumuman->id,
                    'judul'               => $pengumuman->judul,
                    'isi'                 => $pengumuman->isi,
                    'dipinned'            => (bool) $pengumuman->dipinned,
                    'sudah_kadaluarsa'    => $sudahKadaluarsa,
                    'dipublikasikan_pada' => $pengumuman->dipublikasikan_pada?->toIso8601String(),
                    'kadaluarsa_pada'     => $pengumuman->kadaluarsa_pada?->toIso8601String(),
                    'dibuat_oleh'         => $pengumuman->dibuatOleh?->name,
                ],
                'terkait' => $terkait->map(fn ($p) => [
                    'id'                  => $p->id,
                    'judul'               => $p->judul,
                    'dipublikasikan_pada' => $p->dipublikasikan_pada?->toIso8601String(),
                    'dibuat_oleh'         => $p->dibuatOleh?->name,
                ])->values(),
            ],
        ]);
    }
}