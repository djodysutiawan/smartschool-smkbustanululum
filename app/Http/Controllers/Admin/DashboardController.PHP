<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiGuru;          // ← TAMBAHAN: absensi guru
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\JadwalPiketGuru;      // ← TAMBAHAN: jadwal piket untuk widget guru belum absen
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Notifikasi;
use App\Models\Pelanggaran;
use App\Models\Pengumuman;
use App\Models\RiwayatScanQr;
use App\Models\SesiQrGuru;           // ← TAMBAHAN: sesi QR guru aktif
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\Ujian;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today     = Carbon::today();
        $thisMonth = Carbon::now();

        $tahunAktif = TahunAjaran::getAktif();

        // ── Statistik utama ──────────────────────────────────────────────────
        $stats = [
            'total_siswa'          => Siswa::count(),
            'siswa_aktif'          => Siswa::aktif()->count(),
            'total_guru'           => Guru::count(),
            'guru_aktif'           => Guru::aktif()->count(),
            'total_kelas'          => Kelas::aktif()->count(),
            'total_mata_pelajaran' => MataPelajaran::where('is_active', true)->count(),
            'total_pengguna'       => User::count(),
        ];

        // ── Absensi SISWA hari ini ────────────────────────────────────────────
        $hadirHariIni = Absensi::whereIn('status', ['hadir', 'telat'])
            ->whereDate('tanggal', $today)->count();
        $izinHariIni  = Absensi::where('status', 'izin')
            ->whereDate('tanggal', $today)->count();
        $sakitHariIni = Absensi::where('status', 'sakit')
            ->whereDate('tanggal', $today)->count();
        $alfaHariIni  = Absensi::where('status', 'alfa')
            ->whereDate('tanggal', $today)->count();

        $totalAbsensiHariIni = $hadirHariIni + $izinHariIni + $sakitHariIni + $alfaHariIni;

        $absensiHariIni = [
            'hadir'            => $hadirHariIni,
            'izin'             => $izinHariIni,
            'sakit'            => $sakitHariIni,
            'alfa'             => $alfaHariIni,
            'persentase_hadir' => $totalAbsensiHariIni > 0
                ? round(($hadirHariIni / $totalAbsensiHariIni) * 100)
                : 0,
        ];

        // ── Absensi GURU hari ini ─────────────────────────────────────────────
        $totalGuruAktif       = Guru::aktif()->count();
        $guruHadirHariIni     = AbsensiGuru::whereIn('status', ['hadir', 'telat'])
                                    ->whereDate('tanggal', $today)->count();
        $guruIzinHariIni      = AbsensiGuru::where('status', 'izin')
                                    ->whereDate('tanggal', $today)->count();
        $guruSakitHariIni     = AbsensiGuru::where('status', 'sakit')
                                    ->whereDate('tanggal', $today)->count();
        $guruAlfaHariIni      = AbsensiGuru::where('status', 'alfa')
                                    ->whereDate('tanggal', $today)->count();
        $guruSudahAbsen       = AbsensiGuru::whereDate('tanggal', $today)->count();
        $guruBelumAbsen       = max(0, $totalGuruAktif - $guruSudahAbsen);

        $absensiGuruHariIni = [
            'hadir'             => $guruHadirHariIni,
            'izin'              => $guruIzinHariIni,
            'sakit'             => $guruSakitHariIni,
            'alfa'              => $guruAlfaHariIni,
            'belum_absen'       => $guruBelumAbsen,
            'total_aktif'       => $totalGuruAktif,
            'persentase_hadir'  => $totalGuruAktif > 0
                ? round(($guruHadirHariIni / $totalGuruAktif) * 100)
                : 0,
        ];

        // ── Daftar guru yang BELUM absen hari ini (untuk alert/notifikasi) ────
        $guruBelumAbsenList = Guru::aktif()
            ->whereDoesntHave('absensiGuru', fn ($q) => $q->whereDate('tanggal', $today))
            ->orderBy('nama_lengkap')
            ->limit(10)  // Batasi 10 untuk tampilan dashboard
            ->get(['id', 'nama_lengkap', 'adalah_guru_piket']);

        // ── Sesi QR Guru aktif hari ini ───────────────────────────────────────
        $sesiQrGuruAktif = SesiQrGuru::aktif()
            ->whereDate('tanggal', $today)
            ->first();

        // ── Absensi guru bulan ini per status ─────────────────────────────────
        $absensiGuruBulanIni = [
            'hadir' => AbsensiGuru::whereIn('status', ['hadir', 'telat'])
                ->whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
            'izin'  => AbsensiGuru::where('status', 'izin')
                ->whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
            'sakit' => AbsensiGuru::where('status', 'sakit')
                ->whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
            'alfa'  => AbsensiGuru::where('status', 'alfa')
                ->whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
        ];

        // ── Grafik absensi GURU 7 hari terakhir ───────────────────────────────
        $absensiGuruGrafik = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);
            return [
                'tanggal' => $date->format('d M'),
                'hadir'   => AbsensiGuru::whereIn('status', ['hadir', 'telat'])
                    ->whereDate('tanggal', $date)->count(),
                'alfa'    => AbsensiGuru::where('status', 'alfa')
                    ->whereDate('tanggal', $date)->count(),
            ];
        });

        // ── Pelanggaran stats ────────────────────────────────────────────────
        $pelanggaranStats = [
            'hari_ini'  => Pelanggaran::whereDate('tanggal', $today)->count(),
            'bulan_ini' => Pelanggaran::whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
            'pending'   => Pelanggaran::where('status', 'pending')->count(),
            'diproses'  => Pelanggaran::where('status', 'diproses')->count(),
        ];

        // ── Pelanggaran terbaru ──────────────────────────────────────────────
        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'kategori'])
            ->latest('tanggal')
            ->limit(5)
            ->get();

        // ── Grafik absensi SISWA 7 hari terakhir ─────────────────────────────
        $absensiGrafik = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);
            return [
                'tanggal' => $date->format('d M'),
                'hadir'   => Absensi::whereIn('status', ['hadir', 'telat'])
                    ->whereDate('tanggal', $date)->count(),
                'alfa'    => Absensi::where('status', 'alfa')
                    ->whereDate('tanggal', $date)->count(),
            ];
        });

        // ── Scan QR SISWA hari ini ────────────────────────────────────────────
        $scanHariIni = [
            'total'    => RiwayatScanQr::whereDate('dipindai_pada', $today)->count(),
            'berhasil' => RiwayatScanQr::where('hasil', 'berhasil')
                ->whereDate('dipindai_pada', $today)->count(),
            'gagal'    => RiwayatScanQr::where('hasil', '!=', 'berhasil')
                ->whereDate('dipindai_pada', $today)->count(),
        ];

        // ── Ujian mendatang ──────────────────────────────────────────────────
        $ujianMendatang = Ujian::where('status', 'aktif')
            ->where('tanggal', '>=', $today)
            ->with(['kelas', 'mataPelajaran'])
            ->orderBy('tanggal')
            ->limit(5)
            ->get();

        // ── Pengumuman terbaru ───────────────────────────────────────────────
        $pengumumanTerbaru = Pengumuman::where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();

        // ── Notifikasi belum dibaca ──────────────────────────────────────────
        $notifikasiCount = Notifikasi::where('sudah_dibaca', false)->count();

        // ── Distribusi siswa per kelas ───────────────────────────────────────
        $distribusiKelas = Kelas::aktif()
            ->withCount('siswa')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->limit(8)
            ->get();

        // ── Jadwal hari ini ──────────────────────────────────────────────────
        $namaHariRaw = Carbon::today()->locale('id')->isoFormat('dddd');
        $hariMap = [
            'senin'    => 'senin',  'selasa'    => 'selasa', 'rabu'      => 'rabu',
            'kamis'    => 'kamis',  'jumat'     => 'jumat',  'sabtu'     => 'sabtu',
            'minggu'   => 'minggu',
            'monday'   => 'senin',  'tuesday'   => 'selasa', 'wednesday' => 'rabu',
            'thursday' => 'kamis',  'friday'    => 'jumat',  'saturday'  => 'sabtu',
            'sunday'   => 'minggu',
        ];
        $hariKey = $hariMap[strtolower($namaHariRaw)] ?? 'senin';

        $jadwalHariIni = JadwalPelajaran::where('hari', $hariKey)
            ->where('is_active', true)
            ->with(['kelas', 'mataPelajaran', 'guru'])
            ->orderBy('jam_mulai')
            ->limit(6)
            ->get();

        // ── Jadwal piket hari ini + status hadir masing-masing ───────────────
        $jadwalPiketHariIni = JadwalPiketGuru::where('hari', $hariKey)
            ->where('is_active', true)
            ->with('guru')
            ->get();

        // Inject status hadir ke koleksi piket tanpa query N+1
        $absensiPiket = AbsensiGuru::whereDate('tanggal', $today)
            ->whereIn('guru_id', $jadwalPiketHariIni->pluck('guru_id')->filter()->unique())
            ->get()
            ->keyBy('guru_id');

        $jadwalPiketHariIni->each(function ($jadwal) use ($absensiPiket) {
            $jadwal->sudah_absen    = $absensiPiket->has($jadwal->guru_id);
            $jadwal->status_absensi = $absensiPiket->get($jadwal->guru_id)?->status;
        });

        // ── Top 5 siswa poin pelanggaran bulan ini ────────────────────────────
        $topPelanggaran = Siswa::withSum(
                ['pelanggaran' => function ($q) use ($thisMonth) {
                    $q->whereMonth('tanggal', $thisMonth->month)
                      ->whereYear('tanggal', $thisMonth->year);
                }],
                'poin'
            )
            ->with('kelas')
            ->orderByDesc('pelanggaran_sum_poin')
            ->limit(5)
            ->get()
            ->filter(fn ($s) => ($s->pelanggaran_sum_poin ?? 0) > 0);

        // ── Absensi SISWA bulan ini per status ────────────────────────────────
        $absensiBulanIni = [
            'hadir' => Absensi::whereIn('status', ['hadir', 'telat'])
                ->whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
            'izin'  => Absensi::where('status', 'izin')
                ->whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
            'sakit' => Absensi::where('status', 'sakit')
                ->whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
            'alfa'  => Absensi::where('status', 'alfa')
                ->whereMonth('tanggal', $thisMonth->month)
                ->whereYear('tanggal', $thisMonth->year)->count(),
        ];

        return view('admin.dashboard', [
            // ── Data lama (tidak diubah) ──────────────────────────────────────
            'today'              => $today,
            'tahunAktif'         => $tahunAktif,
            'stats'              => $stats,
            'absensiHariIni'     => $absensiHariIni,
            'pelanggaranStats'   => $pelanggaranStats,
            'pelanggaranTerbaru' => $pelanggaranTerbaru,
            'absensiGrafik'      => $absensiGrafik,
            'scanHariIni'        => $scanHariIni,
            'ujianMendatang'     => $ujianMendatang,
            'pengumumanTerbaru'  => $pengumumanTerbaru,
            'notifikasiCount'    => $notifikasiCount,
            'distribusiKelas'    => $distribusiKelas,
            'jadwalHariIni'      => $jadwalHariIni,
            'topPelanggaran'     => $topPelanggaran,
            'absensiBulanIni'    => $absensiBulanIni,

            // ── Data BARU: absensi guru ───────────────────────────────────────
            'absensiGuruHariIni'   => $absensiGuruHariIni,
            'absensiGuruBulanIni'  => $absensiGuruBulanIni,
            'absensiGuruGrafik'    => $absensiGuruGrafik,
            'guruBelumAbsenList'   => $guruBelumAbsenList,
            'sesiQrGuruAktif'      => $sesiQrGuruAktif,
            'jadwalPiketHariIni'   => $jadwalPiketHariIni,
        ]);
    }
}