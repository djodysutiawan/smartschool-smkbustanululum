<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\JurnalMengajar;
use App\Models\Notifikasi;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use App\Models\Ujian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $guru = $user->guru;

        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');

        $guruId = $guru->id;

        // Jadwal hari ini
        $hariIni       = strtolower(now()->locale('id')->dayName);
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas', 'ruang'])
            ->where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        // Statistik tugas
        $totalTugas     = Tugas::where('guru_id', $guruId)->count();
        $tugasBelumNilai = PengumpulanTugas::whereHas('tugas', fn ($q) => $q->where('guru_id', $guruId))
            ->whereIn('status', ['dikumpulkan', 'terlambat'])
            ->count();

        // Statistik ujian aktif
        $ujianAktif = Ujian::where('guru_id', $guruId)
            ->where('is_active', true)
            ->count();

        // Jurnal mengajar bulan ini
        $jurnalBulanIni = JurnalMengajar::where('guru_id', $guruId)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Absensi hari ini (yang dicatat oleh guru ini)
        $absensiHariIni = Absensi::where('dicatat_oleh', $user->id)
            ->whereDate('tanggal', today())
            ->count();

        // Notifikasi belum dibaca
        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        // Jurnal terbaru
        $jurnalTerbaru = JurnalMengajar::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId)
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        // Pengumpulan tugas terbaru yang perlu dinilai
        $pengumpulanTerbaru = PengumpulanTugas::with(['tugas', 'siswa'])
            ->whereHas('tugas', fn ($q) => $q->where('guru_id', $guruId))
            ->whereIn('status', ['dikumpulkan', 'terlambat'])
            ->orderByDesc('dikumpulkan_pada')
            ->limit(5)
            ->get();

        return view('guru.dashboard', compact(
            'guru',
            'jadwalHariIni',
            'totalTugas',
            'tugasBelumNilai',
            'ujianAktif',
            'jurnalBulanIni',
            'absensiHariIni',
            'unreadNotifikasi',
            'jurnalTerbaru',
            'pengumpulanTerbaru',
        ));
    }
}