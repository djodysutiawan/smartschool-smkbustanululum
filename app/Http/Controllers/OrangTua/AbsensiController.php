<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

    // FIX: Daftar nama bulan — dibutuhkan view rekap sebagai $bulanList
    private const BULAN_LIST = [
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

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

        $absensiHariIni = Absensi::with([
                'jadwalPelajaran.mataPelajaran',
                'dicatatOleh',
            ])
            ->where('siswa_id', $anak->id)
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk')
            ->get();

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
     *
     * CATATAN: View rekap.blade.php menggunakan data kehadiran gerbang
     * (scan masuk/pulang), bukan absensi pelajaran. Karena model Absensi
     * hanya punya status hadir/alfa/izin/sakit, variabel yang dibutuhkan
     * view (hariPerTanggal, rekap total_hari_masuk/pulang) dipetakan dari
     * data absensi dengan pendekatan berikut:
     *   - "masuk" = status hadir atau telat (ada di sekolah)
     *   - "pulang" = tidak tersedia di model ini → diisi 0 / null
     *
     * Jika ada model KehadiranGerbang terpisah, pindahkan method ini ke
     * KehadiranGerbangController dan ganti query di bawah ke model itu.
     */
    public function rekap(Request $request)
    {
        $orangTua = $this->getOrangTua();
        $anak     = $this->resolveAnak($request, $orangTua);
        $anakList = $orangTua->siswa()->with('kelas')->get();

        $tahun = $request->filled('tahun') ? (int) $request->tahun : now()->year;
        $bulan = $request->filled('bulan') ? (int) $request->bulan : now()->month;

        // FIX: Kirim $bulanList ke view — sebelumnya tidak ada sama sekali
        $bulanList = self::BULAN_LIST;

        // FIX: Kirim $tahunList ke view
        $tahunList = range(now()->year - 2, now()->year);

        // Ambil semua absensi bulan ini
        $absensiList = Absensi::with(['jadwalPelajaran.mataPelajaran'])
            ->where('siswa_id', $anak->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        // FIX: Buat $hariPerTanggal — view membutuhkan array/collection
        // dengan struktur ['tanggal', 'masuk', 'pulang'].
        // Karena model Absensi adalah absensi pelajaran (bukan gerbang),
        // kita petakan: masuk = absensi pertama hari itu jika hadir/telat,
        // pulang = null (tidak ada data pulang di model ini).
        $hariPerTanggal = $absensiList
            ->groupBy(fn($a) => $a->tanggal->format('Y-m-d'))
            ->map(function ($absensiHari, $tanggalStr) {
                $absensiHadir = $absensiHari->whereIn('status', ['hadir', 'telat'])->first();

                return [
                    'tanggal' => \Carbon\Carbon::parse($tanggalStr),
                    // 'masuk' diisi absensi pertama yang hadir/telat
                    // Field waktu_scan dan sesiGerbang tidak ada di model Absensi —
                    // view akan menampilkan '—' untuk kolom jam dan sesi.
                    'masuk'   => $absensiHadir,
                    // Pulang tidak tersedia di model absensi pelajaran
                    'pulang'  => null,
                ];
            })
            ->sortBy('tanggal')
            ->values();

        // FIX: $rekap dengan key yang sesuai view:
        //   total_hari_masuk  → hari dengan setidaknya 1 absensi hadir/telat
        //   total_hari_pulang → tidak ada datanya, isi 0
        //   total_scan        → total row absensi bulan ini (proxy untuk scan)
        $hariMasuk = $absensiList
            ->whereIn('status', ['hadir', 'telat'])
            ->groupBy(fn($a) => $a->tanggal->format('Y-m-d'))
            ->count();

        $rekap = [
            'total_hari_masuk'  => $hariMasuk,
            'total_hari_pulang' => 0,          // tidak ada di model Absensi
            'total_scan'        => $absensiList->count(),
        ];

        // FIX: $rekapTahunan dengan key 'masuk' dan 'pulang' sesuai view
        // (view memakai array_column($rekapTahunan, 'masuk') dan 'pulang')
        $rekapTahunan = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulanData = Absensi::where('siswa_id', $anak->id)
                ->whereMonth('tanggal', $m)
                ->whereYear('tanggal', $tahun)
                ->get();

            $rekapTahunan[$m] = [
                // Jumlah hari unik yang ada absensi hadir/telat
                'masuk'  => $bulanData
                    ->whereIn('status', ['hadir', 'telat'])
                    ->groupBy(fn($a) => $a->tanggal->format('Y-m-d'))
                    ->count(),
                // Pulang tidak ada datanya
                'pulang' => 0,
            ];
        }

        $statusList = self::STATUS_LIST;

        return view('orangtua.absensi.rekap', compact(
            'anak',
            'anakList',
            'absensiList',
            'hariPerTanggal',   // FIX: ditambahkan
            'rekap',            // FIX: key disesuaikan dengan view
            'rekapTahunan',     // FIX: key disesuaikan dengan view
            'bulan',
            'tahun',
            'bulanList',        // FIX: ditambahkan
            'tahunList',
            'statusList',
        ));
    }
}