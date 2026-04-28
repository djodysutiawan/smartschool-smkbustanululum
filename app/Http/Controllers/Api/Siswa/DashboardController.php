<?php

namespace App\Http\Controllers\Api\Siswa;

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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function getSiswa(): \App\Models\Siswa
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * GET /api/siswa/dashboard
     * Data lengkap dashboard siswa.
     */
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user  = Auth::user();
        $siswa = $this->getSiswa();

        // ── Jadwal hari ini ──────────────────────────────────────────────
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
        $bulan = now()->month;
        $tahun = now()->year;

        $rekapBulanIni = [
            'hadir' => Absensi::where('siswa_id', $siswa->id)
                ->whereIn('status', ['hadir', 'telat'])
                ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
            'izin'  => Absensi::where('siswa_id', $siswa->id)
                ->where('status', 'izin')
                ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
            'sakit' => Absensi::where('siswa_id', $siswa->id)
                ->where('status', 'sakit')
                ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
            'alfa'  => Absensi::where('siswa_id', $siswa->id)
                ->where('status', 'alfa')
                ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
        ];

        $totalHariEfektif = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count();

        $persentaseHadir = $totalHariEfektif > 0
            ? round(($rekapBulanIni['hadir'] / $totalHariEfektif) * 100)
            : 0;

        // ── Tugas belum dikumpulkan ──────────────────────────────────────
        $tugasBelumDikumpulkan = Tugas::with(['mataPelajaran', 'guru'])
            ->dipublikasikan()
            ->where('kelas_id', $siswa->kelas_id)
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $siswa->id))
            ->where(function ($q) {
                $q->where('batas_waktu', '>=', now())->orWhere('izinkan_terlambat', true);
            })
            ->orderBy('batas_waktu')
            ->limit(5)
            ->get();

        $totalTugasDikumpulkan = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->whereMonth('created_at', now()->month)->count();

        // ── Ujian aktif & mendatang ──────────────────────────────────────
        $now        = Carbon::now();
        $ujianKelas = Ujian::with(['mataPelajaran', 'sesi' => fn ($q) =>
                $q->where('siswa_id', $siswa->id)
            ])
            ->where('kelas_id', $siswa->kelas_id)
            ->whereDate('tanggal', '>=', $now->toDateString())
            ->whereDate('tanggal', '<=', $now->copy()->addDays(30)->toDateString())
            ->orderBy('tanggal')->orderBy('jam_mulai')
            ->get();

        $ujianAktif = $ujianKelas
            ->filter(fn ($u) =>
                $u->sudahDimulai() && ! $u->sudahBerakhir()
                && $u->bolehIkut($siswa->id)
                && ! $u->sesi->whereIn('status', ['selesai', 'habis_waktu'])->count()
            )->take(5)->values();

        $ujianMendatang = $ujianKelas
            ->filter(fn ($u) => ! $u->sudahDimulai())
            ->take(3)->values();

        // ── Materi terbaru ───────────────────────────────────────────────
        $materiTerbaru = Materi::with('mataPelajaran')
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan()
            ->orderByDesc('created_at')
            ->limit(5)->get();

        // ── Nilai terbaru ────────────────────────────────────────────────
        $nilaiTerbaru = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('created_at')
            ->limit(5)->get();

        $rataRataNilai = Nilai::where('siswa_id', $siswa->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->avg('nilai_akhir') ?? 0;

        // ── Pelanggaran & notifikasi ─────────────────────────────────────
        $totalPelanggaran = Pelanggaran::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', now()->year)->count();

        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)->count();

        $notifikasiTerbaru = Notifikasi::where('pengguna_id', $user->id)
            ->orderByDesc('created_at')->limit(3)->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'siswa'                  => $siswa,
                'jadwal_hari_ini'        => $jadwalHariIni,
                'absensi_hari_ini'       => $absensiHariIni,
                'rekap_bulan_ini'        => $rekapBulanIni,
                'total_hari_efektif'     => $totalHariEfektif,
                'persentase_hadir'       => $persentaseHadir,
                'tugas_belum_dikumpulkan'=> $tugasBelumDikumpulkan,
                'total_tugas_dikumpulkan'=> $totalTugasDikumpulkan,
                'ujian_aktif'            => $ujianAktif,
                'ujian_mendatang'        => $ujianMendatang,
                'materi_terbaru'         => $materiTerbaru,
                'nilai_terbaru'          => $nilaiTerbaru,
                'rata_rata_nilai'        => round($rataRataNilai, 2),
                'total_pelanggaran'      => $totalPelanggaran,
                'unread_notifikasi'      => $unreadNotifikasi,
                'notifikasi_terbaru'     => $notifikasiTerbaru,
            ],
        ]);
    }
}