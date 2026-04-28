<?php

namespace App\Http\Controllers\Api\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Notifikasi;
use App\Models\Pelanggaran;
use App\Models\Tugas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function getOrangTua()
    {
        $orangTua = Auth::user()->orangTua;
        abort_if(! $orangTua, 403, 'Akun Anda tidak terhubung dengan data orang tua.');
        return $orangTua;
    }

    /**
     * GET /api/ortu/dashboard
     *
     * Data ringkasan dashboard orang tua.
     */
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user     = Auth::user();
        $orangTua = $this->getOrangTua();

        $anakList = $orangTua->siswa()->with('kelas')->get();
        $anak     = $anakList->first();

        // Absensi hari ini (anak pertama)
        $absensiHariIni = $anak
            ? Absensi::where('siswa_id', $anak->id)
                ->whereDate('tanggal', today())
                ->first()
            : null;

        // Rekap absensi bulan ini per anak
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

        // Tugas belum dikumpulkan (anak pertama)
        $tugasBelumDikumpulkan = $anak
            ? Tugas::where('kelas_id', $anak->kelas_id)
                ->where('dipublikasikan', true)
                ->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $anak->id))
                ->where('batas_waktu', '>=', now())
                ->orderBy('batas_waktu')
                ->limit(5)
                ->get()
            : collect();

        // Total pelanggaran tahun ini (anak pertama)
        $totalPelanggaran = $anak
            ? Pelanggaran::where('siswa_id', $anak->id)
                ->whereYear('tanggal', now()->year)
                ->where('status', '!=', 'dibatalkan')
                ->count()
            : 0;

        // Rata-rata nilai akhir (anak pertama)
        $rataRataNilai = $anak
            ? Nilai::where('siswa_id', $anak->id)->avg('nilai_akhir')
            : null;

        // Notifikasi belum dibaca
        $unreadNotifikasi = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        return response()->json([
            'orang_tua'               => $orangTua,
            'anak_list'               => $anakList,
            'anak'                    => $anak,
            'absensi_hari_ini'        => $absensiHariIni,
            'rekap_absensi'           => $rekapAbsensi,
            'tugas_belum_dikumpulkan' => $tugasBelumDikumpulkan,
            'total_pelanggaran'       => $totalPelanggaran,
            'rata_rata_nilai'         => $rataRataNilai ? round($rataRataNilai, 1) : null,
            'unread_notifikasi'       => $unreadNotifikasi,
        ]);
    }
}