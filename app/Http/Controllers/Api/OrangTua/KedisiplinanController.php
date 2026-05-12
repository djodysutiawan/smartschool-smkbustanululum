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
    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        if (! $orangTua) {
            abort(response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak terhubung dengan data orang tua.',
            ], 403));
        }
        return $orangTua;
    }

    private function resolveAnak(Request $request, $orangTua)
    {
        $anakList = $orangTua->siswa()->with('kelas')->get();
        if ($anakList->isEmpty()) {
            abort(response()->json(['success' => false, 'message' => 'Data anak tidak ditemukan.'], 404));
        }

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', (int) $request->siswa_id);
            if (! $anak) {
                abort(response()->json(['success' => false, 'message' => 'Siswa ini bukan anak Anda.'], 403));
            }
            return $anak;
        }

        return $anakList->first();
    }

    // ── Riwayat ───────────────────────────────────────────────────────────────

    /**
     * GET /api/ortu/kedisiplinan/riwayat
     * Query: ?siswa_id= &kategori_id= &tanggal_dari= &tanggal_sampai= &tingkat= &status= &page=
     */
    public function riwayat(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anakList = $orangTua->siswa()->with('kelas')->get();
        $anak     = $this->resolveAnak($request, $orangTua);

        $query = Pelanggaran::with(['kategori', 'dicatatOleh'])
            ->where('siswa_id', $anak->id);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', (int) $request->kategori_id);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('tingkat')) {
            $query->whereHas('kategori', fn ($q) => $q->where('tingkat', $request->tingkat));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pelanggaran  = $query->orderByDesc('tanggal')->paginate(15)->withQueryString();
        $kategoriList = KategoriPelanggaran::orderBy('nama')->get();

        $semuaTahunIni = Pelanggaran::with('kategori')
            ->where('siswa_id', $anak->id)
            ->aktif()
            ->whereYear('tanggal', now()->year)
            ->get();

        $totalPoin     = $semuaTahunIni->sum('poin');
        $totalBerat    = $semuaTahunIni->filter(fn ($p) => ($p->kategori->tingkat ?? '') === 'berat')->count();
        $totalSedang   = $semuaTahunIni->filter(fn ($p) => ($p->kategori->tingkat ?? '') === 'sedang')->count();
        $totalRingan   = $semuaTahunIni->filter(fn ($p) => ($p->kategori->tingkat ?? '') === 'ringan')->count();

        $rekapKategori = $semuaTahunIni
            ->groupBy('kategori_pelanggaran_id')
            ->map(fn ($g) => [
                'nama'    => $g->first()->kategori?->nama ?? '-',
                'total'   => $g->count(),
                'tingkat' => $g->first()->kategori?->tingkat ?? 'ringan',
            ])
            ->sortByDesc('total')
            ->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'anak'          => [
                    'id'           => $anak->id,
                    'nama_lengkap' => $anak->nama_lengkap,
                    'kelas'        => $anak->kelas?->nama_kelas,
                ],
                'anak_list'     => $anakList->map(fn ($a) => [
                    'id'           => $a->id,
                    'nama_lengkap' => $a->nama_lengkap,
                ])->values(),
                'total_poin'    => $totalPoin,
                'total_berat'   => $totalBerat,
                'total_sedang'  => $totalSedang,
                'total_ringan'  => $totalRingan,
                'rekap_kategori' => $rekapKategori,
                'kategori_list' => $kategoriList->map(fn ($k) => [
                    'id'      => $k->id,
                    'nama'    => $k->nama,
                    'tingkat' => $k->tingkat,
                ])->values(),
                'pelanggaran'   => $pelanggaran->map(fn ($p) => [
                    'id'           => $p->id,
                    'tanggal'      => $p->tanggal?->toDateString(),
                    'kategori'     => $p->kategori?->nama,
                    'tingkat'      => $p->kategori?->tingkat,
                    'poin'         => $p->poin,
                    'keterangan'   => $p->keterangan,
                    'status'       => $p->status,
                    'dicatat_oleh' => $p->dicatatOleh?->name,
                ])->values(),
                'pagination'    => [
                    'current_page' => $pelanggaran->currentPage(),
                    'last_page'    => $pelanggaran->lastPage(),
                    'per_page'     => $pelanggaran->perPage(),
                    'total'        => $pelanggaran->total(),
                ],
            ],
        ]);
    }
}