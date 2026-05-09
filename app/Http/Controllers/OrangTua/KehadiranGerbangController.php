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

        $scanMasuk  = $scanHariIni->where('tipe', 'masuk')->first();
        $scanPulang = $scanHariIni->where('tipe', 'pulang')->first();

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

        $totalHariMasuk = AbsensiGerbang::where('siswa_id', $anak->id)
            ->valid()->masuk()
            ->distinct('tanggal_scan')->count('tanggal_scan');

        $totalHariPulang = AbsensiGerbang::where('siswa_id', $anak->id)
            ->valid()->pulang()
            ->distinct('tanggal_scan')->count('tanggal_scan');

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
        $scanBulanIni = AbsensiGerbang::where('siswa_id', $anak->id)
            ->valid()
            ->whereMonth('tanggal_scan', $bulan)
            ->whereYear('tanggal_scan', $tahun)
            ->orderBy('waktu_scan')
            ->get();

        // Kelompokkan per tanggal → pasangkan masuk & pulang
        $hariPerTanggal = $scanBulanIni
            ->groupBy(fn ($s) => $s->tanggal_scan->format('Y-m-d'))
            ->map(fn ($group) => [
                'tanggal' => $group->first()->tanggal_scan,
                'masuk'   => $group->where('tipe', 'masuk')->first(),
                'pulang'  => $group->where('tipe', 'pulang')->first(),
            ])
            ->values();

        $rekap = [
            'total_hari_masuk'  => $scanBulanIni->where('tipe', 'masuk')
                ->unique('tanggal_scan')->count(),
            'total_hari_pulang' => $scanBulanIni->where('tipe', 'pulang')
                ->unique('tanggal_scan')->count(),
            'total_scan'        => $scanBulanIni->count(),
        ];

        $tahunList = collect(range(now()->year - 2, now()->year));
        $bulanList = collect(range(1, 12))->mapWithKeys(fn ($b) => [
            $b => \Carbon\Carbon::create()->month($b)->locale('id')->isoFormat('MMMM'),
        ]);

        return view('orangtua.kehadiran-gerbang.rekap', compact(
            'anak',
            'anakList',
            'hariPerTanggal',
            'rekap',
            'bulan',
            'tahun',
            'bulanList',
            'tahunList',
        ));
    }
}