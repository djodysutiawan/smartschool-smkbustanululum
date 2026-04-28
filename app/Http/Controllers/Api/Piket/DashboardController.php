<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\IzinKeluarSiswa;
use App\Models\JadwalPiketGuru;
use App\Models\LaporanHarianPiket;
use App\Models\LogPiket;
use App\Models\Notifikasi;
use App\Models\Pelanggaran;
use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use PiketActiveGuru;

    /**
     * GET /api/piket/dashboard
     *
     * Data ringkasan dashboard guru piket.
     */
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $logHariIni  = $this->resolveActiveLog();
        $guruAktif   = $logHariIni?->guru;
        $guruAktifId = $logHariIni?->guru_id;

        $hariIni       = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $jadwalHariIni = null;
        $jadwalSaya    = collect();

        if ($guruAktifId) {
            $jadwalHariIni = JadwalPiketGuru::where('guru_id', $guruAktifId)
                ->where('hari', $hariIni)
                ->where('is_active', true)
                ->first();

            $jadwalSaya = JadwalPiketGuru::where('guru_id', $guruAktifId)
                ->where('is_active', true)
                ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
                ->get();
        }

        $stats = [
            'piket_checkin_hari_ini' => LogPiket::whereDate('tanggal', today())
                ->whereNotNull('masuk_pada')
                ->count(),
            'pelanggaran_hari_ini' => Pelanggaran::whereDate('tanggal', today())->count(),
            'izin_menunggu'        => IzinKeluarSiswa::where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count(),
            'izin_sedang_keluar'   => IzinKeluarSiswa::belumKembali()->count(),
        ];

        $unreadCount = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        $notifikasiTerbaru = Notifikasi::where('pengguna_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $pengumuman = Pengumuman::whereNotNull('dipublikasikan_pada')
            ->whereIn('target_role', ['semua', 'guru_piket'])
            ->where(function ($q) {
                $q->whereNull('kadaluarsa_pada')
                  ->orWhere('kadaluarsa_pada', '>', now());
            })
            ->orderByDesc('dipinned')
            ->orderByDesc('dipublikasikan_pada')
            ->take(3)
            ->get();

        $izinMenunggu = IzinKeluarSiswa::with('siswa.kelas')
            ->where('status', IzinKeluarSiswa::STATUS_MENUNGGU)
            ->latest()
            ->take(5)
            ->get();

        $pelanggaranHariIni = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->whereDate('tanggal', today())
            ->latest()
            ->take(5)
            ->get();

        $guruSedangPiket = LogPiket::with('guru')
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->get();

        $laporanHariIni = LaporanHarianPiket::where('dibuat_oleh', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        return response()->json([
            'guru_aktif'          => $guruAktif,
            'log_hari_ini'        => $logHariIni,
            'hari_ini'            => $hariIni,
            'jadwal_hari_ini'     => $jadwalHariIni,
            'jadwal_saya'         => $jadwalSaya,
            'stats'               => $stats,
            'unread_count'        => $unreadCount,
            'notifikasi_terbaru'  => $notifikasiTerbaru,
            'pengumuman'          => $pengumuman,
            'izin_menunggu'       => $izinMenunggu,
            'pelanggaran_hari_ini'=> $pelanggaranHariIni,
            'guru_sedang_piket'   => $guruSedangPiket,
            'laporan_hari_ini'    => $laporanHariIni,
        ]);
    }
}