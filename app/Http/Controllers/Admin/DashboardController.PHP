<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\IzinKeluarSiswa;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Notifikasi;
use App\Models\Nilai;
use App\Models\Pelanggaran;
use App\Models\Pengumuman;
use App\Models\PengumpulanTugas;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ── Statistik entitas utama ──────────────────────────────────────
        $totalSiswa  = Siswa::count();
        $totalGuru   = Guru::count();
        $totalKelas  = Kelas::count();
        $totalUser   = User::count();

        // ── Absensi hari ini (rekap global) ─────────────────────────────
        // Konsisten: groupBy status agar tidak boros query (fix inkonsistensi Siswa)
        $absensiHariIniRaw = Absensi::whereDate('tanggal', today())
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $absensiHariIni = [
            'hadir' => ($absensiHariIniRaw['hadir']  ?? 0) + ($absensiHariIniRaw['telat'] ?? 0),
            'izin'  => $absensiHariIniRaw['izin']  ?? 0,
            'sakit' => $absensiHariIniRaw['sakit'] ?? 0,
            'alfa'  => $absensiHariIniRaw['alfa']  ?? 0,
        ];

        $totalAbsensiHariIni = array_sum($absensiHariIni);

        // ── Rekap absensi bulan ini (global) ─────────────────────────────
        $absensiBulanIniRaw = Absensi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $absensiBulanIni = [
            'hadir' => ($absensiBulanIniRaw['hadir']  ?? 0) + ($absensiBulanIniRaw['telat'] ?? 0),
            'izin'  => $absensiBulanIniRaw['izin']  ?? 0,
            'sakit' => $absensiBulanIniRaw['sakit'] ?? 0,
            'alfa'  => $absensiBulanIniRaw['alfa']  ?? 0,
        ];

        // ── Pelanggaran ──────────────────────────────────────────────────
        $pelanggaranHariIni = Pelanggaran::whereDate('tanggal', today())
            ->where('status', '!=', 'dibatalkan')
            ->count();

        $pelanggaranBulanIni = Pelanggaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->where('status', '!=', 'dibatalkan')
            ->count();

        // 5 pelanggaran terbaru
        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->where('status', '!=', 'dibatalkan')
            ->latest('tanggal')
            ->limit(5)
            ->get();

        // ── Tugas & Pengumpulan ──────────────────────────────────────────
        $totalTugas         = Tugas::where('dipublikasikan', true)->count();
        $tugasBelumDinilai  = PengumpulanTugas::whereIn('status', ['dikumpulkan', 'terlambat'])->count();

        // ── Ujian ────────────────────────────────────────────────────────
        // Filter PHP-level untuk konsistensi (hindari asumsi kolom is_active)
        $now    = Carbon::now();
        $ujians = Ujian::with('mataPelajaran')
            ->whereDate('tanggal', '>=', $now->toDateString())
            ->whereDate('tanggal', '<=', $now->copy()->addDays(7)->toDateString())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        $ujianAktif     = $ujians->filter(fn ($u) => $u->sudahDimulai() && ! $u->sudahBerakhir())->values();
        $ujianMendatang = $ujians->filter(fn ($u) => ! $u->sudahDimulai())->take(5)->values();

        // ── Izin keluar ──────────────────────────────────────────────────
        $izinMenunggu     = IzinKeluarSiswa::where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count();
        $izinSedangKeluar = IzinKeluarSiswa::belumKembali()->count();

        // ── Nilai rata-rata per kelas (top 5 kelas) ──────────────────────
        $rataRataNilaiPerKelas = Nilai::select(
                'siswa.kelas_id',
                'kelas.nama_kelas',
                DB::raw('AVG(nilai.nilai_akhir) as rata')
            )
            ->join('siswa', 'siswa.id', '=', 'nilai.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->groupBy('siswa.kelas_id', 'kelas.nama_kelas')
            ->orderByDesc('rata')
            ->limit(5)
            ->get();

        // ── Siswa dengan pelanggaran terbanyak tahun ini (top 5) ─────────
        $siswaRawanPelanggaran = Siswa::select(
                'siswa.id',
                'siswa.nama_lengkap',
                'siswa.kelas_id',
                DB::raw('count(pelanggaran.id) as total_pelanggaran')
            )
            ->join('pelanggaran', 'pelanggaran.siswa_id', '=', 'siswa.id')
            ->whereYear('pelanggaran.tanggal', now()->year)
            ->where('pelanggaran.status', '!=', 'dibatalkan')
            ->groupBy('siswa.id', 'siswa.nama_lengkap', 'siswa.kelas_id')
            ->with('kelas')
            ->orderByDesc('total_pelanggaran')
            ->limit(5)
            ->get();

        // ── Pengumuman aktif ──────────────────────────────────────────────
        $pengumuman = Pengumuman::whereNotNull('dipublikasikan_pada')
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->take(3)
            ->get();

        // ── Tren absensi 7 hari terakhir (untuk chart) ───────────────────
        $trenAbsensi = Absensi::whereDate('tanggal', '>=', now()->subDays(6)->toDateString())
            ->whereDate('tanggal', '<=', today()->toDateString())
            ->select(
                'tanggal',
                'status',
                DB::raw('count(*) as total')
            )
            ->groupBy('tanggal', 'status')
            ->orderBy('tanggal')
            ->get()
            ->groupBy('tanggal')
            ->map(fn ($rows) => [
                'hadir' => $rows->whereIn('status', ['hadir', 'telat'])->sum('total'),
                'alpha' => $rows->where('status', 'alfa')->sum('total'),
                'izin'  => $rows->where('status', 'izin')->sum('total'),
                'sakit' => $rows->where('status', 'sakit')->sum('total'),
            ]);

        // ── Notifikasi belum dibaca ──────────────────────────────────────
        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        $notifikasiTerbaru = Notifikasi::where('pengguna_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // ── Jadwal hari ini (semua kelas) ────────────────────────────────
        // Nama hari konsisten: Carbon locale('id') + isoFormat (sama dgn Piket)
        $hariIni       = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'guru', 'kelas', 'ruang'])
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            // Entitas
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalUser',
            // Absensi
            'absensiHariIni',
            'absensiBulanIni',
            'totalAbsensiHariIni',
            'trenAbsensi',
            // Pelanggaran
            'pelanggaranHariIni',
            'pelanggaranBulanIni',
            'pelanggaranTerbaru',
            'siswaRawanPelanggaran',
            // Tugas & Ujian
            'totalTugas',
            'tugasBelumDinilai',
            'ujianAktif',
            'ujianMendatang',
            // Izin
            'izinMenunggu',
            'izinSedangKeluar',
            // Akademik
            'rataRataNilaiPerKelas',
            // Lainnya
            'pengumuman',
            'jadwalHariIni',
            'unreadNotifikasi',
            'notifikasiTerbaru',
        ));
    }
}