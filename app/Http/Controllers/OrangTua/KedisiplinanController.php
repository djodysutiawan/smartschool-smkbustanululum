<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KedisiplinanController extends Controller
{
    // ── Helpers ───────────────────────────────────────────────────────────────

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

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * GET /ortu/kedisiplinan/riwayat
     *
     * Riwayat pelanggaran anak (read-only).
     * Orang tua tidak bisa mengubah data apapun.
     *
     * Poin dihitung dari semua status KECUALI 'dibatalkan'
     * karena dibatalkan berarti pelanggaran tidak jadi dihitung.
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

        // Total poin aktif tahun ini (kecuali yang dibatalkan)
        $totalPoin = Pelanggaran::where('siswa_id', $anak->id)
            ->whereYear('tanggal', now()->year)
            ->where('status', '!=', 'dibatalkan')
            ->sum('poin');

        // Ambil semua pelanggaran tahun ini dengan kategori untuk rekap
        $semuaTahunIni = Pelanggaran::with('kategori')
            ->where('siswa_id', $anak->id)
            ->where('status', '!=', 'dibatalkan')
            ->whereYear('tanggal', now()->year)
            ->get();

        // Rekap per kategori (nama + jumlah) — group di PHP tanpa query tambahan
        $rekapKategori = $semuaTahunIni
            ->groupBy('kategori_pelanggaran_id')
            ->map(fn ($g) => [
                'nama'    => $g->first()->kategori->nama ?? '-',
                'total'   => $g->count(),
                'tingkat' => $g->first()->kategori->tingkat ?? 'ringan',
            ]);

        // Rekap per tingkat — kolom `tingkat` ada di KategoriPelanggaran (verified)
        $totalBerat  = $semuaTahunIni->filter(fn ($p) => ($p->kategori->tingkat ?? '') === 'berat')->count();
        $totalSedang = $semuaTahunIni->filter(fn ($p) => ($p->kategori->tingkat ?? '') === 'sedang')->count();
        $totalRingan = $semuaTahunIni->filter(fn ($p) => ($p->kategori->tingkat ?? '') === 'ringan')->count();

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

    // ── TOTAL POIN ────────────────────────────────────────────────────────────

    /**
     * GET /ortu/kedisiplinan/total-poin
     *
     * Ringkasan poin kedisiplinan anak lintas tahun.
     */
    public function totalPoin(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahun = $request->filled('tahun') ? (int) $request->tahun : now()->year;

        $totalPoin = Pelanggaran::where('siswa_id', $anak->id)
            ->where('status', '!=', 'dibatalkan')
            ->whereYear('tanggal', $tahun)
            ->sum('poin');

        $totalKasus = Pelanggaran::where('siswa_id', $anak->id)
            ->where('status', '!=', 'dibatalkan')
            ->whereYear('tanggal', $tahun)
            ->count();

        // Tren per bulan
        $trenBulanan = collect(range(1, 12))->map(fn ($b) => [
            'bulan' => $b,
            'poin'  => Pelanggaran::where('siswa_id', $anak->id)
                ->where('status', '!=', 'dibatalkan')
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $b)
                ->sum('poin'),
        ]);

        $tahunList = collect(range(now()->year - 2, now()->year));

        return view('orangtua.kedisiplinan.total-poin', compact(
            'anak',
            'anakList',
            'totalPoin',
            'totalKasus',
            'trenBulanan',
            'tahun',
            'tahunList',
        ));
    }

    // ── STATUS ────────────────────────────────────────────────────────────────

    /**
     * GET /ortu/kedisiplinan/status
     *
     * Status kedisiplinan terkini anak — pelanggaran pending/diproses.
     */
    public function status(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        // Pelanggaran yang masih aktif diproses
        $pelanggaranAktif = Pelanggaran::with('kategori')
            ->where('siswa_id', $anak->id)
            ->whereIn('status', ['pending', 'diproses', 'banding'])
            ->orderByDesc('tanggal')
            ->get();

        // Total poin aktif tahun ini
        $totalPoinTahunIni = Pelanggaran::where('siswa_id', $anak->id)
            ->where('status', '!=', 'dibatalkan')
            ->whereYear('tanggal', now()->year)
            ->sum('poin');

        return view('orangtua.kedisiplinan.status', compact(
            'anak',
            'anakList',
            'pelanggaranAktif',
            'totalPoinTahunIni',
        ));
    }
}