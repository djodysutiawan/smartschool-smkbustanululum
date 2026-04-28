<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Notifikasi;
use App\Models\Nilai;
use App\Models\Pelanggaran;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Helper: ambil OrangTua beserta relasi siswa dari user yang login.
     */
    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        abort_if(! $orangTua, 403, 'Akun Anda tidak terhubung dengan data orang tua.');
        return $orangTua;
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user     = Auth::user();
        $orangTua = $this->getOrangTua();

        // Orang tua bisa punya lebih dari 1 anak; ambil semua
        $anakList = $orangTua->siswa()->with('kelas')->get();

        // Jika hanya 1 anak, tampilkan dashboard terfokus
        $anak = $anakList->first();

        // ── Absensi hari ini per anak ────────────────────────────────────
        $absensiHariIni = $anak
            ? Absensi::where('siswa_id', $anak->id)
                ->whereDate('tanggal', today())
                ->first()
            : null;

        // ── Rekap absensi bulan ini ─────────────────────────────────────
        $rekapAbsensi = [];
        foreach ($anakList as $a) {
            $base = Absensi::where('siswa_id', $a->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);

            $rekapAbsensi[$a->id] = [
                'nama'  => $a->nama_lengkap,
                'hadir' => (clone $base)->whereIn('status', ['hadir', 'telat'])->count(),
                'izin'  => (clone $base)->where('status', 'izin')->count(),
                'sakit' => (clone $base)->where('status', 'sakit')->count(),
                'alfa'  => (clone $base)->where('status', 'alfa')->count(),
            ];
        }

        // ── Tugas belum dikumpulkan (anak pertama) ───────────────────────
        // Kolom: dipublikasikan (boolean), bukan is_active
        $tugasBelumDikumpulkan = $anak
            ? Tugas::where('kelas_id', $anak->kelas_id)
                ->where('dipublikasikan', true)
                ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $anak->id))
                ->where('batas_waktu', '>=', now())
                ->orderBy('batas_waktu')
                ->limit(5)
                ->get()
            : collect();

        // ── Pelanggaran tahun ini (anak pertama) ─────────────────────────
        $totalPelanggaran = $anak
            ? Pelanggaran::where('siswa_id', $anak->id)
                ->whereYear('tanggal', now()->year)
                ->where('status', '!=', 'dibatalkan')
                ->count()
            : 0;

        // ── Rata-rata nilai terbaru ─────────────────────────────────────
        // Kolom nilai_akhir di tabel nilai (bukan kolom 'nilai')
        $rataRataNilai = $anak
            ? Nilai::where('siswa_id', $anak->id)->avg('nilai_akhir')
            : null;

        // ── Notifikasi belum dibaca ──────────────────────────────────────
        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        return view('OrangTua.dashboard', compact(
            'orangTua',
            'anakList',
            'anak',
            'absensiHariIni',
            'rekapAbsensi',
            'tugasBelumDikumpulkan',
            'totalPelanggaran',
            'rataRataNilai',
            'unreadNotifikasi',
        ));
    }
}