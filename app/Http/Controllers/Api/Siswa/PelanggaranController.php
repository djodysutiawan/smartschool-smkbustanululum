<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\JsonResponse;
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

    /**
     * GET /api/siswa/pelanggaran
     * Daftar pelanggaran milik siswa.
     * Query: ?kategori_id=&status=&tanggal_dari=&tanggal_sampai=&per_page=
     */
    public function index(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $query = Pelanggaran::with(['kategori', 'dicatatOleh'])
            ->where('siswa_id', $siswa->id)
            ->aktif();

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

        $perPage     = min((int) $request->get('per_page', 15), 50);
        $pelanggaran = $query->orderByDesc('tanggal')->paginate($perPage);

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

        return response()->json([
            'success' => true,
            'data'    => [
                'pelanggaran'   => $pelanggaran,
                'kategori_list' => KategoriPelanggaran::orderBy('nama')->get(['id', 'nama']),
                'status_list'   => ['pending', 'diproses', 'selesai', 'banding'],
                'total_poin'    => $totalPoin,
                'rekap_status'  => $rekapStatus,
                'total_catatan' => $totalCatatan,
            ],
        ]);
    }

    /**
     * GET /api/siswa/pelanggaran/{pelanggaran}
     * Detail satu catatan pelanggaran.
     */
    public function show(Pelanggaran $pelanggaran): JsonResponse
    {
        $siswa = $this->getSiswa();

        abort_if($pelanggaran->siswa_id !== $siswa->id, 403, 'Ini bukan data kedisiplinan Anda.');

        $pelanggaran->load(['kategori', 'dicatatOleh', 'siswa.kelas']);

        $totalPoinSiswa = Pelanggaran::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', now()->year)
            ->aktif()
            ->sum('poin');

        return response()->json([
            'success' => true,
            'data'    => [
                'pelanggaran'      => $pelanggaran,
                'total_poin_siswa' => $totalPoinSiswa,
            ],
        ]);
    }
}