<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Pelanggaran;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;

class ProfilAnakController extends Controller
{
    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        abort_if(! $orangTua, 403, 'Akun Anda tidak terhubung dengan data orang tua.');
        return $orangTua;
    }

    /**
     * Daftar anak yang terhubung dengan akun orang tua ini.
     */
    public function index()
    {
        $orangTua = $this->getOrangTua();

        // Gunakan 'pengguna' bukan 'user' — sesuai relasi di model Siswa
        $anakList = $orangTua->siswa()->with(['kelas', 'pengguna'])->orderBy('nama_lengkap')->get();

        // Tambahkan data ringkasan per anak
        $anakList->each(function ($anak) {
            $base = Absensi::where('siswa_id', $anak->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);

            $anak->total_absensi_bulan_ini = (clone $base)
                ->whereIn('status', ['hadir', 'telat'])
                ->count();

            $anak->rata_rata_nilai = Nilai::where('siswa_id', $anak->id)
                ->whereNotNull('nilai_akhir')
                ->avg('nilai_akhir');

            $anak->total_pelanggaran_tahun_ini = Pelanggaran::where('siswa_id', $anak->id)
                ->where('status', '!=', 'dibatalkan')
                ->whereYear('tanggal', now()->year)
                ->count();
        });

        return view('orangtua.profil-anak.index', compact('orangTua', 'anakList'));
    }

    /**
     * Detail profil satu anak beserta ringkasan akademik & kehadiran.
     */
    public function show(int $siswaId)
    {
        $orangTua = $this->getOrangTua();

        // Pastikan anak ini benar milik orang tua yang login
        // Gunakan 'pengguna' bukan 'user'
        $anak = $orangTua->siswa()
            ->with(['kelas', 'pengguna'])
            ->findOrFail($siswaId);

        // ── Absensi bulan ini ─────────────────────────────────────────
        $base = Absensi::where('siswa_id', $anak->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);

        $absensiSummary = [
            'hadir' => (clone $base)->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => (clone $base)->where('status', 'izin')->count(),
            'sakit' => (clone $base)->where('status', 'sakit')->count(),
            'alfa'  => (clone $base)->where('status', 'alfa')->count(),
        ];

        // ── Riwayat absensi terbaru ───────────────────────────────────
        $absensiTerbaru = Absensi::where('siswa_id', $anak->id)
            ->orderByDesc('tanggal')
            ->limit(7)
            ->get();

        // ── Nilai per mapel ───────────────────────────────────────────
        $nilaiList = Nilai::where('siswa_id', $anak->id)
            ->with('mataPelajaran')
            ->latest()
            ->get();

        $rataRataNilai = $nilaiList->whereNotNull('nilai_akhir')->avg('nilai_akhir');

        // ── Tugas belum dikumpulkan ───────────────────────────────────
        // Kolom: dipublikasikan (bukan is_active)
        $tugasBelum = Tugas::where('kelas_id', $anak->kelas_id)
            ->where('dipublikasikan', true)
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $anak->id))
            ->where('batas_waktu', '>=', now())
            ->with('mataPelajaran')
            ->orderBy('batas_waktu')
            ->limit(5)
            ->get();

        // ── Pelanggaran tahun ini ─────────────────────────────────────
        $pelanggaranList = Pelanggaran::where('siswa_id', $anak->id)
            ->with('kategori')
            ->where('status', '!=', 'dibatalkan')
            ->whereYear('tanggal', now()->year)
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        $totalPoinPelanggaran = $pelanggaranList->sum('poin');

        return view('orangtua.profil-anak.show', compact(
            'anak',
            'orangTua',
            'absensiSummary',
            'absensiTerbaru',
            'nilaiList',
            'rataRataNilai',
            'tugasBelum',
            'pelanggaranList',
            'totalPoinPelanggaran',
        ));
    }
}