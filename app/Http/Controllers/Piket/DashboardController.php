<?php

namespace App\Http\Controllers\Piket;

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
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use PiketActiveGuru;

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ── Guru aktif dari log check-in (bukan dari Auth::user()->guru) ──────
        // Karena 1 akun guru_piket dipakai bergantian, "guru siapa yang bertugas"
        // ditentukan dari log check-in aktif hari ini.
        $logHariIni    = $this->resolveActiveLog();
        $guruAktif     = $logHariIni?->guru;     // null jika belum check-in
        $guruAktifId   = $logHariIni?->guru_id;

        // ── Jadwal piket hari ini berdasarkan guru yang sedang check-in ───────
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

        // ── Statistik hari ini (scope global, bukan per-guru) ─────────────────
        $stats = [
            'piket_checkin_hari_ini' => LogPiket::whereDate('tanggal', today())
                ->whereNotNull('masuk_pada')
                ->count(),

            'pelanggaran_hari_ini' => Pelanggaran::whereDate('tanggal', today())->count(),

            'izin_menunggu'      => IzinKeluarSiswa::where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count(),
            'izin_sedang_keluar' => IzinKeluarSiswa::belumKembali()->count(),
        ];

        // ── Notifikasi milik akun yang login ──────────────────────────────────
        $unreadCount = Notifikasi::where('pengguna_id', $user->id)
            ->where('sudah_dibaca', false)
            ->count();

        $notifikasiTerbaru = Notifikasi::where('pengguna_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // ── Pengumuman aktif ──────────────────────────────────────────────────
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

        // ── Izin keluar menunggu (5 terbaru) ─────────────────────────────────
        $izinMenunggu = IzinKeluarSiswa::with('siswa.kelas')
            ->where('status', IzinKeluarSiswa::STATUS_MENUNGGU)
            ->latest()
            ->take(5)
            ->get();

        // ── Pelanggaran hari ini (5 terbaru) ─────────────────────────────────
        $pelanggaranHariIni = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->whereDate('tanggal', today())
            ->latest()
            ->take(5)
            ->get();

        // ── Semua guru piket yang sedang aktif check-in hari ini ─────────────
        $guruSedangPiket = LogPiket::with('guru')
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->get();

        // ── Laporan harian ────────────────────────────────────────────────────
        // FIX: LaporanHarianPiket tidak punya kolom guru_id.
        // Kolom yang tersedia adalah `dibuat_oleh` (FK ke users.id).
        // Kita cari laporan hari ini berdasarkan user yang sedang login.
        $laporanHariIni = LaporanHarianPiket::where('dibuat_oleh', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        return view('piket.dashboard', compact(
            'guruAktif',        // guru yang sedang check-in (bisa null)
            'logHariIni',       // log aktif hari ini (bisa null jika belum check-in)
            'hariIni',
            'jadwalHariIni',
            'jadwalSaya',
            'stats',
            'unreadCount',
            'notifikasiTerbaru',
            'pengumuman',
            'izinMenunggu',
            'pelanggaranHariIni',
            'guruSedangPiket',
            'laporanHariIni',
        ));
    }
}