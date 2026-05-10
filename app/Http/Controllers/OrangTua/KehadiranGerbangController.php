<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGerbang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehadiranGerbangController extends Controller
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

    // ── STATUS HARI INI ───────────────────────────────────────────────────────

    /**
     * GET /ortu/kehadiran-gerbang/status-hari-ini
     *
     * Orang tua melihat apakah anak sudah scan masuk/pulang di gerbang hari ini.
     * Hanya scan valid (normal, manual, koreksi) yang ditampilkan.
     */
    public function statusHariIni(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $scanHariIni = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $anak->id)
            ->valid()
            ->hariIni()
            ->orderBy('waktu_scan')
            ->get();

        // Ambil scan masuk & pulang pertama yang valid hari ini
        $scanMasuk  = $scanHariIni->firstWhere('tipe', 'masuk');
        $scanPulang = $scanHariIni->firstWhere('tipe', 'pulang');

        return view('orangtua.kehadiran-gerbang.status-hari-ini', compact(
            'anak',
            'anakList',
            'scanHariIni',
            'scanMasuk',
            'scanPulang',
        ));
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * GET /ortu/kehadiran-gerbang/riwayat
     *
     * Riwayat seluruh log masuk & pulang anak di gerbang.
     * Filter: tanggal_dari, tanggal_sampai, tipe.
     */
    public function riwayat(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $query = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $anak->id)
            ->valid();

        if ($request->filled('tipe') && in_array($request->tipe, ['masuk', 'pulang'])) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_scan', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_scan', '<=', $request->tanggal_sampai);
        }

        $riwayat = $query->orderByDesc('waktu_scan')->paginate(20)->withQueryString();

        // Hitung total hari unik, bukan total scan (lebih bermakna untuk orang tua)
        $totalHariMasuk = AbsensiGerbang::where('siswa_id', $anak->id)
            ->valid()
            ->masuk()
            ->selectRaw('COUNT(DISTINCT tanggal_scan) as total')
            ->value('total') ?? 0;

        $totalHariPulang = AbsensiGerbang::where('siswa_id', $anak->id)
            ->valid()
            ->pulang()
            ->selectRaw('COUNT(DISTINCT tanggal_scan) as total')
            ->value('total') ?? 0;

        return view('orangtua.kehadiran-gerbang.riwayat', compact(
            'anak',
            'anakList',
            'riwayat',
            'totalHariMasuk',
            'totalHariPulang',
        ));
    }

    // ── REKAP ─────────────────────────────────────────────────────────────────

    /**
     * GET /ortu/kehadiran-gerbang/rekap
     *
     * Rekap bulanan kehadiran gerbang anak.
     * Default: bulan & tahun berjalan.
     */
    public function rekap(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $bulan = $request->filled('bulan') ? (int) $request->bulan : now()->month;
        $tahun = $request->filled('tahun') ? (int) $request->tahun : now()->year;

        // Scan valid anak bulan ini
        $scanBulanIni = AbsensiGerbang::with('sesiGerbang')
            ->where('siswa_id', $anak->id)
            ->valid()
            ->whereMonth('tanggal_scan', $bulan)
            ->whereYear('tanggal_scan', $tahun)
            ->orderBy('waktu_scan')
            ->get();

        // Kelompokkan per tanggal → pasangkan masuk & pulang
        // PERBAIKAN: Gunakan format string saat groupBy agar key konsisten,
        // dan amankan casting tanggal_scan sebagai Carbon (sudah di-cast di model).
        $hariPerTanggal = $scanBulanIni
            ->groupBy(fn ($s) => $s->tanggal_scan->format('Y-m-d'))
            ->map(fn ($group, $tanggalStr) => [
                'tanggal' => $group->first()->tanggal_scan,
                'masuk'   => $group->firstWhere('tipe', 'masuk'),
                'pulang'  => $group->firstWhere('tipe', 'pulang'),
            ])
            ->values();

        $rekap = [
            'total_hari_masuk'  => $scanBulanIni
                ->where('tipe', 'masuk')
                ->pluck('tanggal_scan')
                ->map(fn ($d) => $d->format('Y-m-d'))
                ->unique()
                ->count(),
            'total_hari_pulang' => $scanBulanIni
                ->where('tipe', 'pulang')
                ->pluck('tanggal_scan')
                ->map(fn ($d) => $d->format('Y-m-d'))
                ->unique()
                ->count(),
            'total_scan'        => $scanBulanIni->count(),
        ];

        // Rekap per bulan untuk tren tahunan (masuk & pulang)
        $rekapTahunan = [];
        for ($m = 1; $m <= 12; $m++) {
            $scanBulan = AbsensiGerbang::where('siswa_id', $anak->id)
                ->valid()
                ->whereMonth('tanggal_scan', $m)
                ->whereYear('tanggal_scan', $tahun)
                ->get();

            $rekapTahunan[$m] = [
                'masuk'  => $scanBulan->where('tipe', 'masuk')
                    ->pluck('tanggal_scan')
                    ->map(fn ($d) => $d->format('Y-m-d'))
                    ->unique()->count(),
                'pulang' => $scanBulan->where('tipe', 'pulang')
                    ->pluck('tanggal_scan')
                    ->map(fn ($d) => $d->format('Y-m-d'))
                    ->unique()->count(),
            ];
        }

        $tahunList = collect(range(now()->year - 2, now()->year));
        $bulanList = collect(range(1, 12))->mapWithKeys(fn ($b) => [
            $b => \Carbon\Carbon::create()->month($b)->locale('id')->isoFormat('MMMM'),
        ]);

        return view('orangtua.kehadiran-gerbang.rekap', compact(
            'anak',
            'anakList',
            'hariPerTanggal',
            'rekap',
            'rekapTahunan',
            'bulan',
            'tahun',
            'bulanList',
            'tahunList',
        ));
    }
}