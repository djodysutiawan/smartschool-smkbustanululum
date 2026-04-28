<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KedisiplinanController extends Controller
{
    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        abort_if(! $orangTua, 403, 'Akun Anda tidak terhubung dengan data orang tua.');
        return $orangTua;
    }

    private function resolveAnak(Request $request, $orangTua)
    {
        $anakList = $orangTua->siswa()->get();
        abort_if($anakList->isEmpty(), 404, 'Data anak tidak ditemukan.');

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', $request->siswa_id);
            abort_if(! $anak, 403, 'Siswa ini bukan anak Anda.');
            return $anak;
        }

        return $anakList->first();
    }

    /**
     * GET /api/ortu/kedisiplinan/riwayat
     *
     * Riwayat pelanggaran / kedisiplinan anak (read-only).
     *
     * Query params:
     *   - siswa_id      (optional)
     *   - kategori_id   (optional)
     *   - tanggal_dari  (optional) Y-m-d
     *   - tanggal_sampai (optional) Y-m-d
     *   - per_page      (optional, default 15)
     */
    public function riwayat(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $query = Pelanggaran::with(['kategori', 'dicatatOleh'])
            ->where('siswa_id', $anak->id);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', $request->kategori_id);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $perPage      = $request->get('per_page', 15);
        $pelanggaran  = $query->orderByDesc('tanggal')->paginate($perPage)->withQueryString();
        $kategoriList = KategoriPelanggaran::orderBy('nama')->get();

        $totalPoin = Pelanggaran::where('siswa_id', $anak->id)
            ->whereYear('tanggal', now()->year)
            ->sum('poin');

        $semuaTahunIni = Pelanggaran::with('kategori')
            ->where('siswa_id', $anak->id)
            ->whereYear('tanggal', now()->year)
            ->get();

        $rekapKategori = $semuaTahunIni
            ->groupBy('kategori_pelanggaran_id')
            ->map(fn ($g) => [
                'nama'   => $g->first()->kategori->nama ?? '-',
                'total'  => $g->count(),
                'tingkat'=> $g->first()->kategori->tingkat ?? 'ringan',
            ])
            ->values();

        $totalBerat  = $semuaTahunIni->filter(fn ($p) => $p->kategori?->tingkat === 'berat')->count();
        $totalSedang = $semuaTahunIni->filter(fn ($p) => $p->kategori?->tingkat === 'sedang')->count();
        $totalRingan = $semuaTahunIni->filter(fn ($p) => $p->kategori?->tingkat === 'ringan')->count();

        return response()->json([
            'anak'           => $anak,
            'anak_list'      => $anakList,
            'pelanggaran'    => $pelanggaran,
            'kategori_list'  => $kategoriList,
            'total_poin'     => $totalPoin,
            'rekap_kategori' => $rekapKategori,
            'total_berat'    => $totalBerat,
            'total_sedang'   => $totalSedang,
            'total_ringan'   => $totalRingan,
        ]);
    }
}