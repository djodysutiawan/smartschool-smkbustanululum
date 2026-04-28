<?php
 
namespace App\Http\Controllers\OrangTua;
 
use App\Http\Controllers\Controller;
use App\Models\Absensi;
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
     * Status kehadiran anak hari ini.
     */
    public function statusHariIni(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();
 
        $absensiHariIni = Absensi::with(['jadwalPelajaran.mataPelajaran', 'dicatatOleh'])
            ->where('siswa_id', $anak->id)
            ->whereDate('tanggal', today())
            ->first();
 
        // Jadwal hari ini anak
        $hariIni = strtolower(now()->locale('id')->dayName);
 
        return view('orangtua.absensi.status-hari-ini', compact(
            'anak',
            'anakList',
            'absensiHariIni',
            'hariIni',
        ));
    }
 
    /**
     * Riwayat kehadiran anak dengan filter.
     */
    public function riwayat(Request $request)
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
 
        $absensi    = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $statusList = self::STATUS_LIST;
 
        $rekap = [
            'hadir' => Absensi::where('siswa_id', $anak->id)->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => Absensi::where('siswa_id', $anak->id)->where('status', 'izin')->count(),
            'sakit' => Absensi::where('siswa_id', $anak->id)->where('status', 'sakit')->count(),
            'alfa'  => Absensi::where('siswa_id', $anak->id)->where('status', 'alfa')->count(),
        ];
 
        return view('orangtua.absensi.riwayat', compact(
            'anak',
            'anakList',
            'absensi',
            'statusList',
            'rekap',
        ));
    }
 
    /**
     * Rekap bulanan kehadiran anak.
     * Menampilkan matriks hari x bulan dalam 1 tahun.
     */
    public function rekap(Request $request)
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
 
        // Rekap per bulan untuk chart tahunan
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
 
        $statusList  = self::STATUS_LIST;
        $tahunList   = range(now()->year - 2, now()->year);
 
        return view('orangtua.absensi.rekap', compact(
            'anak',
            'anakList',
            'absensiList',
            'rekapBulan',
            'rekapTahunan',
            'bulan',
            'tahun',
            'tahunList',
            'statusList',
        ));
    }
}
