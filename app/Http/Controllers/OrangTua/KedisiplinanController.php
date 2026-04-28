<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Pelanggaran;
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
     * Riwayat pelanggaran / kedisiplinan anak (read-only).
     */
    public function riwayat(Request $request)
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

        $pelanggaran  = $query->orderByDesc('tanggal')->paginate(15)->withQueryString();
        $kategoriList = KategoriPelanggaran::orderBy('nama')->get();

        // Total poin: poin tersimpan langsung di kolom pelanggaran.poin
        $totalPoin = Pelanggaran::where('siswa_id', $anak->id)
            ->whereYear('tanggal', now()->year)
            ->sum('poin');

        // Rekap per kategori — ambil semua data tahun ini lalu group di PHP
        $semuaTahunIni = Pelanggaran::with('kategori')
            ->where('siswa_id', $anak->id)
            ->whereYear('tanggal', now()->year)
            ->get();

        // Rekap per kategori (nama + jumlah)
        $rekapKategori = $semuaTahunIni
            ->groupBy('kategori_pelanggaran_id')
            ->map(fn ($g) => [
                'nama'   => $g->first()->kategori->nama ?? '-',
                'total'  => $g->count(),
                'tingkat'=> $g->first()->kategori->tingkat ?? 'ringan',
            ]);

        // Rekap per tingkat — hitung dari koleksi yang sudah diambil, tanpa query tambahan
        $totalBerat  = $semuaTahunIni->filter(fn ($p) => $p->kategori?->tingkat === 'berat')->count();
        $totalSedang = $semuaTahunIni->filter(fn ($p) => $p->kategori?->tingkat === 'sedang')->count();
        $totalRingan = $semuaTahunIni->filter(fn ($p) => $p->kategori?->tingkat === 'ringan')->count();

        return view('orangtua.kedisiplinan.riwayat', compact(
            'anak',
            'anakList',
            'pelanggaran',
            'kategoriList',
            'totalPoin',
            'rekapKategori',
            'totalBerat',
            'totalSedang',
            'totalRingan',
        ));
    }
}