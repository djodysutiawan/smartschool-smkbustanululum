<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

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
     * GET /api/ortu/absensi/hari-ini
     *
     * Status kehadiran anak hari ini.
     */
    public function statusHariIni(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $absensiHariIni = Absensi::with(['jadwalPelajaran.mataPelajaran', 'dicatatOleh'])
            ->where('siswa_id', $anak->id)
            ->whereDate('tanggal', today())
            ->first();

        $hariIni = strtolower(now()->locale('id')->dayName);

        return response()->json([
            'anak'             => $anak,
            'anak_list'        => $anakList,
            'absensi_hari_ini' => $absensiHariIni,
            'hari_ini'         => $hariIni,
        ]);
    }

    /**
     * GET /api/ortu/absensi/riwayat
     *
     * Riwayat kehadiran anak dengan filter.
     *
     * Query params:
     *   - siswa_id     (optional)
     *   - status       (optional) hadir|telat|izin|sakit|alfa
     *   - tanggal_dari (optional) Y-m-d
     *   - tanggal_sampai (optional) Y-m-d
     *   - per_page     (optional, default 20)
     */
    public function riwayat(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $query = Absensi::with(['jadwalPelajaran.mataPelajaran', 'dicatatOleh'])
            ->where('siswa_id', $anak->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $perPage = $request->get('per_page', 20);
        $absensi = $query->orderByDesc('tanggal')->paginate($perPage)->withQueryString();

        $rekap = [
            'hadir' => Absensi::where('siswa_id', $anak->id)->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => Absensi::where('siswa_id', $anak->id)->where('status', 'izin')->count(),
            'sakit' => Absensi::where('siswa_id', $anak->id)->where('status', 'sakit')->count(),
            'alfa'  => Absensi::where('siswa_id', $anak->id)->where('status', 'alfa')->count(),
        ];

        return response()->json([
            'anak'        => $anak,
            'anak_list'   => $anakList,
            'absensi'     => $absensi,
            'rekap'       => $rekap,
            'status_list' => self::STATUS_LIST,
        ]);
    }

    /**
     * GET /api/ortu/absensi/rekap
     *
     * Rekap bulanan kehadiran anak.
     *
     * Query params:
     *   - siswa_id (optional)
     *   - bulan    (optional, default bulan ini) 1-12
     *   - tahun    (optional, default tahun ini)
     */
    public function rekap(Request $request): JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahun = $request->filled('tahun') ? (int) $request->tahun : now()->year;
        $bulan = $request->filled('bulan') ? (int) $request->bulan : now()->month;

        $absensiList = Absensi::where('siswa_id', $anak->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get()
            ->keyBy(fn ($a) => $a->tanggal->format('d'));

        $rekapBulan = [
            'hadir' => $absensiList->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => $absensiList->where('status', 'izin')->count(),
            'sakit' => $absensiList->where('status', 'sakit')->count(),
            'alfa'  => $absensiList->where('status', 'alfa')->count(),
        ];

        $rekapTahunan = [];
        for ($m = 1; $m <= 12; $m++) {
            $rekapTahunan[$m] = [
                'hadir' => Absensi::where('siswa_id', $anak->id)
                    ->whereIn('status', ['hadir', 'telat'])
                    ->whereMonth('tanggal', $m)
                    ->whereYear('tanggal', $tahun)
                    ->count(),
                'alfa'  => Absensi::where('siswa_id', $anak->id)
                    ->where('status', 'alfa')
                    ->whereMonth('tanggal', $m)
                    ->whereYear('tanggal', $tahun)
                    ->count(),
            ];
        }

        return response()->json([
            'anak'          => $anak,
            'anak_list'     => $anakList,
            'absensi_list'  => $absensiList->values(),
            'rekap_bulan'   => $rekapBulan,
            'rekap_tahunan' => $rekapTahunan,
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'tahun_list'    => range(now()->year - 2, now()->year),
            'status_list'   => self::STATUS_LIST,
        ]);
    }
}