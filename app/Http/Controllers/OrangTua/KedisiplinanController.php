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
        // Eager-load kelas agar tidak N+1 di view
        $anakList = $orangTua->siswa()->with('kelas')->get();
        abort_if($anakList->isEmpty(), 404, 'Data anak tidak ditemukan.');

        if ($request->filled('siswa_id')) {
            $anak = $anakList->firstWhere('id', (int) $request->siswa_id);
            abort_if(! $anak, 403, 'Siswa ini bukan anak Anda.');
            return $anak;
        }

        return $anakList->first();
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * GET /ortu/kedisiplinan/riwayat
     *
     * Riwayat pelanggaran anak (read-only, paginated, filterable).
     * Poin dihitung dari semua status KECUALI 'dibatalkan'.
     */
    public function riwayat(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anakList = $orangTua->siswa()->with('kelas')->get();
        $anak     = $this->resolveAnak($request, $orangTua);

        // ── Query utama (semua tahun, bisa difilter) ──────────────────────────
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

        // ── Rekap tahun berjalan (gunakan scope aktif) ────────────────────────
        $semuaTahunIni = Pelanggaran::with('kategori')
            ->where('siswa_id', $anak->id)
            ->aktif()                          // scope: NOT IN ['dibatalkan']
            ->whereYear('tanggal', now()->year)
            ->get();

        // Total poin aktif tahun ini — sum di PHP karena koleksi sudah diload
        $totalPoin = $semuaTahunIni->sum('poin');

        // Rekap per kategori — group di PHP tanpa query tambahan
        $rekapKategori = $semuaTahunIni
            ->groupBy('kategori_pelanggaran_id')
            ->map(fn ($g) => [
                'nama'    => $g->first()->kategori->nama ?? '-',
                'total'   => $g->count(),
                'tingkat' => $g->first()->kategori->tingkat ?? 'ringan',
            ])
            ->sortByDesc('total')
            ->values();

        // Rekap per tingkat
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
     * Ringkasan poin kedisiplinan anak — tren bulanan & historis.
     */
    public function totalPoin(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anakList = $orangTua->siswa()->with('kelas')->get();
        $anak     = $this->resolveAnak($request, $orangTua);

        $tahun     = $request->filled('tahun') ? (int) $request->tahun : now()->year;
        $tahunList = collect(range(max(now()->year - 4, 2020), now()->year))->reverse()->values();

        // Satu query tren bulanan — group di DB, bukan 12 query N+1
        $trenRaw = Pelanggaran::selectRaw('MONTH(tanggal) as bulan, SUM(poin) as total_poin, COUNT(*) as total_kasus')
            ->where('siswa_id', $anak->id)
            ->aktif()
            ->whereYear('tanggal', $tahun)
            ->groupBy('bulan')
            ->pluck('total_poin', 'bulan'); // ['1' => 10, '3' => 5, ...]

        $trenKasusRaw = Pelanggaran::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total_kasus')
            ->where('siswa_id', $anak->id)
            ->aktif()
            ->whereYear('tanggal', $tahun)
            ->groupBy('bulan')
            ->pluck('total_kasus', 'bulan');

        // Isi array 12 bulan (bulan tanpa data = 0)
        $trenBulanan = collect(range(1, 12))->map(fn ($b) => [
            'bulan'       => $b,
            'poin'        => (int) ($trenRaw[$b] ?? 0),
            'total_kasus' => (int) ($trenKasusRaw[$b] ?? 0),
        ]);

        $totalPoin  = $trenBulanan->sum('poin');
        $totalKasus = $trenBulanan->sum('total_kasus');

        // Rekap per tingkat tahun ini — satu query aggregate
        $rekapTingkat = Pelanggaran::selectRaw('kategori_pelanggaran.tingkat, COUNT(*) as total, SUM(pelanggaran.poin) as poin')
            ->join('kategori_pelanggaran', 'pelanggaran.kategori_pelanggaran_id', '=', 'kategori_pelanggaran.id')
            ->where('siswa_id', $anak->id)
            ->aktif()
            ->whereYear('tanggal', $tahun)
            ->groupBy('kategori_pelanggaran.tingkat')
            ->get()
            ->keyBy('tingkat');

        // Bulan dengan poin tertinggi
        $bulanTertinggi = $trenBulanan->sortByDesc('poin')->first();

        return view('orangtua.kedisiplinan.total-poin', compact(
            'anak',
            'anakList',
            'totalPoin',
            'totalKasus',
            'trenBulanan',
            'rekapTingkat',
            'tahun',
            'tahunList',
            'bulanTertinggi',
        ));
    }

    // ── STATUS ────────────────────────────────────────────────────────────────

    /**
     * GET /ortu/kedisiplinan/status
     *
     * Status kedisiplinan terkini anak — pelanggaran aktif/pending.
     */
    public function status(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anakList = $orangTua->siswa()->with('kelas')->get();
        $anak     = $this->resolveAnak($request, $orangTua);

        // Gunakan konstanta model agar tidak ada typo
        $pelanggaranAktif = Pelanggaran::with(['kategori', 'dicatatOleh'])
            ->where('siswa_id', $anak->id)
            ->whereIn('status', [
                Pelanggaran::STATUS_PENDING,
                Pelanggaran::STATUS_DIPROSES,
                Pelanggaran::STATUS_BANDING,
            ])
            ->orderByDesc('tanggal')
            ->get();

        // Pelanggaran yang baru selesai (30 hari terakhir)
        $recentSelesai = Pelanggaran::with(['kategori'])
            ->where('siswa_id', $anak->id)
            ->where('status', Pelanggaran::STATUS_SELESAI)
            ->where(function ($q) {
                $q->whereNotNull('diselesaikan_pada')
                    ->where('diselesaikan_pada', '>=', now()->subDays(30))
                    ->orWhere(function ($q2) {
                        // Fallback ke updated_at jika diselesaikan_pada null
                        $q2->whereNull('diselesaikan_pada')
                            ->where('updated_at', '>=', now()->subDays(30));
                    });
            })
            ->orderByDesc('diselesaikan_pada')
            ->limit(5)
            ->get();

        // Total poin aktif tahun ini
        $totalPoinTahunIni = Pelanggaran::where('siswa_id', $anak->id)
            ->aktif()
            ->whereYear('tanggal', now()->year)
            ->sum('poin');

        // Statistik status
        $statsStatus = Pelanggaran::selectRaw('status, COUNT(*) as total')
            ->where('siswa_id', $anak->id)
            ->whereYear('tanggal', now()->year)
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('orangtua.kedisiplinan.status', compact(
            'anak',
            'anakList',
            'pelanggaranAktif',
            'recentSelesai',
            'totalPoinTahunIni',
            'statsStatus',
        ));
    }
}