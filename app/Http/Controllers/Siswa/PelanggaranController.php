<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        $query = Pelanggaran::with(['kategori', 'dicatatOleh'])
            ->where('siswa_id', $siswa->id)
            ->aktif(); // ✅ fix: scopeAktif() → aktif()

        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', $request->kategori_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $pelanggaran  = $query->orderByDesc('tanggal')->paginate(15)->withQueryString();
        $kategoriList = KategoriPelanggaran::orderBy('nama')->get();
        $statusList   = ['pending', 'diproses', 'selesai', 'banding'];

        $totalPoin = Pelanggaran::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', now()->year)
            ->aktif()
            ->sum('poin');

        $rekapStatus = Pelanggaran::where('siswa_id', $siswa->id)
            ->aktif()
            ->selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $totalCatatan = Pelanggaran::where('siswa_id', $siswa->id)
            ->aktif()
            ->count();

        return view('siswa.pelanggaran.index', compact(
            'pelanggaran', 'kategoriList', 'statusList',
            'totalPoin', 'rekapStatus', 'totalCatatan', 'siswa'
        ));
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $siswa = $this->getSiswa();

        abort_if($pelanggaran->siswa_id !== $siswa->id, 403, 'Ini bukan data kedisiplinan Anda.');

        $pelanggaran->load(['kategori', 'dicatatOleh', 'siswa.kelas']);

        $totalPoinSiswa = Pelanggaran::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', now()->year)
            ->aktif()
            ->sum('poin');

        return view('siswa.pelanggaran.show', compact('pelanggaran', 'totalPoinSiswa'));
    }
}