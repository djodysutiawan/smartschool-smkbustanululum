<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\Materi;
use App\Models\Nilai;
use App\Models\Notifikasi;
use App\Models\PengumpulanTugas;
use App\Models\Pelanggaran;
use App\Models\SesiUjian;
use App\Models\Tugas;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Ambil model Siswa dari user yang sedang login.
     * Abort 403 jika user tidak memiliki relasi siswa.
     */
    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user  = Auth::user();
        $siswa = $this->getSiswa();

        // ── Jadwal hari ini ──────────────────────────────────────────────
        // Nama hari dalam bahasa Indonesia (lowercase) sesuai kolom `hari`
        $hariIni       = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'guru', 'ruang'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // ── Absensi hari ini ─────────────────────────────────────────────
        $absensiHariIni = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        // ── Statistik kehadiran bulan ini ────────────────────────────────
        $rekapBulanIni = [
            'hadir' => Absensi::where('siswa_id', $siswa->id)
                ->whereIn('status', ['hadir', 'telat'])
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
            'izin'  => Absensi::where('siswa_id', $siswa->id)
                ->where('status', 'izin')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
            'sakit' => Absensi::where('siswa_id', $siswa->id)
                ->where('status', 'sakit')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
            'alfa'  => Absensi::where('siswa_id', $siswa->id)
                ->where('status', 'alfa')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
        ];

        // Total hari efektif bulan ini (jumlah record absensi)
        $totalHariEfektif = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        $persentaseHadir = $totalHariEfektif > 0
            ? round(($rekapBulanIni['hadir'] / $totalHariEfektif) * 100)
            : 0;

        // ── Tugas belum dikumpulkan (aktif & deadline belum lewat atau boleh terlambat) ──
        $tugasBelumDikumpulkan = Tugas::with(['mataPelajaran', 'guru'])
            ->dipublikasikan()
            ->where('kelas_id', $siswa->kelas_id)
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $siswa->id))
            ->where(function ($q) {
                // Masih dalam deadline ATAU mengizinkan keterlambatan
                $q->where('batas_waktu', '>=', now())
                  ->orWhere('izinkan_terlambat', true);
            })
            ->orderBy('batas_waktu')
            ->limit(5)
            ->get();

        // Tugas sudah dikumpulkan (untuk stats)
        $totalTugasDikumpulkan = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->whereMonth('created_at', now()->month)
            ->count();

        // ── Ujian yang sedang berlangsung & belum diselesaikan siswa ────────
        // CATATAN: kolom `status` & `is_active` tidak ditemukan di tabel DB.
        // Filter status dilakukan di PHP-level via sudahDimulai() / sudahBerakhir()
        // yang merupakan computed attribute dari tanggal + jam_mulai + durasi_menit.
        // Kolom DB yang aman dipakai: kelas_id, tanggal, jam_mulai, durasi_menit.
        $now     = Carbon::now();
        $nowDate = $now->toDateString();

        // Ambil semua ujian kelas untuk tanggal hari ini & ke depan (max 30 hari),
        // lalu filter di PHP agar aman dari perbedaan skema DB.
        $ujianKelas = Ujian::with(['mataPelajaran', 'sesi' => fn ($q) =>
                $q->where('siswa_id', $siswa->id)
            ])
            ->where('kelas_id', $siswa->kelas_id)
            ->whereDate('tanggal', '>=', $nowDate)
            ->whereDate('tanggal', '<=', $now->copy()->addDays(30)->toDateString())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        // Ujian sedang berlangsung: sudah dimulai & belum berakhir & boleh ikut
        $ujianAktif = $ujianKelas
            ->filter(fn ($u) =>
                $u->sudahDimulai()
                && ! $u->sudahBerakhir()
                && $u->bolehIkut($siswa->id)
                && ! $u->sesi->whereIn('status', ['selesai', 'habis_waktu'])->count()
            )
            ->take(5)
            ->values();

        // Ujian mendatang: belum dimulai
        $ujianMendatang = $ujianKelas
            ->filter(fn ($u) => ! $u->sudahDimulai())
            ->take(3)
            ->values();

        // ── Materi terbaru ───────────────────────────────────────────────
        $materiTerbaru = Materi::with('mataPelajaran')
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan()          // scope: where('dipublikasikan', true)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // ── Nilai terbaru ────────────────────────────────────────────────
        $nilaiTerbaru = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Rata-rata nilai bulan ini
        $rataRataNilai = Nilai::where('siswa_id', $siswa->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->avg('nilai_akhir') ?? 0;

        // ── Pelanggaran tahun ini ────────────────────────────────────────
        $totalPelanggaran = Pelanggaran::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', now()->year)
            ->count();

        // ── Notifikasi belum dibaca ──────────────────────────────────────
        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        // Notifikasi terbaru (untuk quick preview)
        $notifikasiTerbaru = Notifikasi::where('pengguna_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'jadwalHariIni',
            'absensiHariIni',
            'rekapBulanIni',
            'totalHariEfektif',
            'persentaseHadir',
            'tugasBelumDikumpulkan',
            'totalTugasDikumpulkan',
            'ujianAktif',
            'ujianMendatang',
            'materiTerbaru',
            'nilaiTerbaru',
            'rataRataNilai',
            'totalPelanggaran',
            'unreadNotifikasi',
            'notifikasiTerbaru',
        ));
    }
}