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

        $anakList = $orangTua->siswa()->with(['kelas', 'pengguna'])->orderBy('nama_lengkap')->get();

        $bulan = now()->month;
        $tahun = now()->year;

        $anakList->each(function ($anak) use ($bulan, $tahun) {
            // Hitung kehadiran bulan ini (hadir + telat)
            $anak->total_absensi_bulan_ini = Absensi::where('siswa_id', $anak->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->whereIn('status', Absensi::STATUS_DIHITUNG_HADIR)
                ->count();

            $anak->rata_rata_nilai = Nilai::where('siswa_id', $anak->id)
                ->whereNotNull('nilai_akhir')
                ->avg('nilai_akhir');

            // FIX: Gunakan scope aktif() dan konstanta — tidak hard-code string 'dibatalkan'
            $anak->total_pelanggaran_tahun_ini = Pelanggaran::where('siswa_id', $anak->id)
                ->aktif()
                ->whereYear('tanggal', $tahun)
                ->count();

            // FIX: Hitung total poin pelanggaran aktif (bukan hanya 5 terakhir)
            $anak->total_poin_pelanggaran = Pelanggaran::where('siswa_id', $anak->id)
                ->aktif()
                ->whereYear('tanggal', $tahun)
                ->sum('poin');
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
        $anak = $orangTua->siswa()
            ->with(['kelas', 'pengguna'])
            ->findOrFail($siswaId);

        $bulan = now()->month;
        $tahun = now()->year;

        // ── Absensi bulan ini ─────────────────────────────────────────
        $baseAbsensi = Absensi::where('siswa_id', $anak->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $absensiSummary = [
            // hadir = hadir + telat (sesuai STATUS_DIHITUNG_HADIR)
            'hadir' => (clone $baseAbsensi)->whereIn('status', Absensi::STATUS_DIHITUNG_HADIR)->count(),
            'izin'  => (clone $baseAbsensi)->where('status', Absensi::STATUS_IZIN)->count(),
            'sakit' => (clone $baseAbsensi)->where('status', Absensi::STATUS_SAKIT)->count(),
            'alfa'  => (clone $baseAbsensi)->where('status', Absensi::STATUS_ALFA)->count(),
        ];

        // ── Riwayat absensi terbaru ───────────────────────────────────
        $absensiTerbaru = Absensi::where('siswa_id', $anak->id)
            ->orderByDesc('tanggal')
            ->limit(10)
            ->get();

        // ── Nilai per mapel ───────────────────────────────────────────
        $nilaiList = Nilai::where('siswa_id', $anak->id)
            ->with('mataPelajaran')
            ->latest()
            ->get();

        $rataRataNilai = $nilaiList->whereNotNull('nilai_akhir')->avg('nilai_akhir');

        // ── Tugas belum dikumpulkan ───────────────────────────────────
        $tugasBelum = Tugas::where('kelas_id', $anak->kelas_id)
            ->dipublikasikan()
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $anak->id))
            ->where('batas_waktu', '>=', now())
            ->with('mataPelajaran')
            ->orderBy('batas_waktu')
            ->limit(5)
            ->get();

        // ── Tugas terlambat (sudah lewat deadline, belum dikumpulkan) ─
        $tugasTerlambat = Tugas::where('kelas_id', $anak->kelas_id)
            ->dipublikasikan()
            ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $anak->id))
            ->where('batas_waktu', '<', now())
            ->where('izinkan_terlambat', false)
            ->with('mataPelajaran')
            ->orderByDesc('batas_waktu')
            ->limit(3)
            ->get();

        // ── Pelanggaran tahun ini ─────────────────────────────────────
        $pelanggaranList = Pelanggaran::where('siswa_id', $anak->id)
            ->with('kategori')
            ->aktif()
            ->whereYear('tanggal', $tahun)
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        // FIX KRITIS: Hitung total poin dari SEMUA pelanggaran aktif tahun ini,
        // bukan hanya 5 yang di-fetch untuk tampilan (bug di versi sebelumnya)
        $totalPoinPelanggaran = Pelanggaran::where('siswa_id', $anak->id)
            ->aktif()
            ->whereYear('tanggal', $tahun)
            ->sum('poin');

        return view('orangtua.profil-anak.show', compact(
            'anak',
            'orangTua',
            'absensiSummary',
            'absensiTerbaru',
            'nilaiList',
            'rataRataNilai',
            'tugasBelum',
            'tugasTerlambat',
            'pelanggaranList',
            'totalPoinPelanggaran',
        ));
    }
}