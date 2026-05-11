<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\SesiQrGuru;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * SesiQrGuruController (Piket)
 *
 * Mengelola sesi QR untuk absensi guru.
 *
 * Model SesiQrGuru:
 *  - kode_qr (UUID) → di-generate ulang saat refresh
 *  - is_active + berlaku_mulai + kadaluarsa_pada → dikombinasikan oleh masihBerlaku()
 *  - scope aktif() → is_active + berlaku_mulai <= now + kadaluarsa_pada >= now
 *
 * Mapping routes ↔ method (setelah alignment):
 *  GET  /sesi-qr-guru              → index
 *  POST /sesi-qr-guru/buka         → buka
 *  POST /sesi-qr-guru/tutup        → tutup
 *  POST /sesi-qr-guru/refresh      → refreshKodeQr
 *  GET  /sesi-qr-guru/status       → status  (JSON polling)
 *
 * Batasan piket vs admin:
 *  - Piket TIDAK bisa melihat riwayat sesi lama (hanya admin)
 *  - Piket TIDAK bisa mengubah durasi / konfigurasi sesi (hanya admin)
 *  - Piket hanya bisa membuka 1 sesi aktif dalam satu waktu
 *
 * Views: resources/views/piket/sesi-qr-guru/
 */
class SesiQrGuruController extends Controller
{
    private const VIEW_PREFIX = 'piket.sesi-qr-guru.';

    /**
     * Durasi sesi QR default dalam menit.
     * Idealnya diambil dari config/setting sekolah.
     */
    private const DURASI_SESI_MENIT = 60;

    // ── INDEX ─────────────────────────────────────────────────────────────────

    /**
     * Tampilkan status sesi QR guru saat ini.
     *
     * Piket melihat:
     *  - Apakah sesi QR sedang aktif
     *  - QR code (kode_qr UUID) yang bisa di-scan guru (jika aktif)
     *  - Tombol buka / tutup / refresh kode QR
     *  - Info: dibuka oleh siapa, jam berapa, berakhir kapan
     *  - Daftar guru yang sudah scan hari ini (10 terbaru)
     */
    public function index(): View
    {
        $sesiAktif = SesiQrGuru::aktif()
            ->with('pembuat:id,name')
            ->first();

        // Guru yang sudah scan via QR hari ini — untuk live feedback piket
        $sudahScanHariIni = AbsensiGuru::with('guru:id,nama_lengkap,nip')
            ->whereDate('tanggal', today())
            ->where('metode', 'qr')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        return view(self::VIEW_PREFIX . 'index', compact(
            'sesiAktif',
            'sudahScanHariIni',
        ));
    }

    // ── BUKA SESI ─────────────────────────────────────────────────────────────

    /**
     * Buka sesi QR baru.
     *
     * Guard:
     *  - Tolak jika sudah ada sesi aktif (piket harus tutup dulu)
     *  - kode_qr di-generate UUID baru (lewat model booted())
     *  - berlaku_mulai = now(), kadaluarsa_pada = now() + DURASI_SESI_MENIT
     */
    public function buka(Request $request): RedirectResponse
    {
        if (SesiQrGuru::aktif()->exists()) {
            return redirect()->route('piket.sesi-qr-guru.index')
                ->with('warning', 'Sesi QR sudah aktif. Tutup sesi sekarang sebelum membuka yang baru.');
        }

        $berlakuMulai    = now();
        $kadaluarsaPada  = now()->addMinutes(self::DURASI_SESI_MENIT);

        SesiQrGuru::create([
            'dibuat_oleh'    => Auth::id(),
            'tanggal'        => today(),
            'berlaku_mulai'  => $berlakuMulai,
            'kadaluarsa_pada'=> $kadaluarsaPada,
            'is_active'      => true,
            // kode_qr di-generate otomatis oleh model booted()
        ]);

        return redirect()->route('piket.sesi-qr-guru.index')
            ->with('success', "Sesi QR berhasil dibuka. Berlaku hingga {$kadaluarsaPada->format('H:i')}. Guru sekarang bisa scan QR untuk absen.");
    }

    // ── TUTUP SESI ────────────────────────────────────────────────────────────

    /**
     * Tutup sesi QR yang sedang aktif.
     *
     * Piket bisa menutup sesi lebih awal agar guru tidak bisa scan
     * di luar jam yang seharusnya.
     *
     * Guard: tolak jika tidak ada sesi aktif.
     */
    public function tutup(Request $request): RedirectResponse
    {
        $sesiAktif = SesiQrGuru::aktif()->first();

        if (! $sesiAktif) {
            return redirect()->route('piket.sesi-qr-guru.index')
                ->with('warning', 'Tidak ada sesi QR yang sedang aktif.');
        }

        // Nonaktifkan dengan meng-set is_active = false dan kadaluarsa_pada = now
        // agar scope aktif() tidak mengembalikannya lagi
        $sesiAktif->update([
            'is_active'       => false,
            'kadaluarsa_pada' => now(),
        ]);

        return redirect()->route('piket.sesi-qr-guru.index')
            ->with('success', 'Sesi QR berhasil ditutup. Guru tidak bisa scan QR lagi.');
    }

    // ── REFRESH KODE QR ───────────────────────────────────────────────────────

    /**
     * Refresh kode_qr sesi yang sedang aktif.
     *
     * Digunakan saat piket curiga QR sudah di-screenshot oleh orang yang
     * tidak berhak. kode_qr lama langsung tidak valid karena AbsensiGuruController
     * mencari SesiQrGuru berdasarkan kode_qr.
     *
     * Sekaligus perpanjang kadaluarsa_pada dari sekarang + DURASI_SESI_MENIT
     * agar tidak mendadak expired setelah refresh.
     *
     * Guard: tolak jika tidak ada sesi aktif.
     */
    public function refreshKodeQr(Request $request): RedirectResponse
    {
        $sesiAktif = SesiQrGuru::aktif()->first();

        if (! $sesiAktif) {
            return redirect()->route('piket.sesi-qr-guru.index')
                ->with('warning', 'Tidak ada sesi QR aktif yang bisa di-refresh.');
        }

        $kadaluarsaBaru = now()->addMinutes(self::DURASI_SESI_MENIT);

        $sesiAktif->update([
            'kode_qr'         => (string) Str::uuid(),
            'kadaluarsa_pada' => $kadaluarsaBaru,
        ]);

        return redirect()->route('piket.sesi-qr-guru.index')
            ->with('success', "Kode QR berhasil di-refresh. QR lama sudah tidak valid. Berlaku hingga {$kadaluarsaBaru->format('H:i')}.");
    }

    // ── STATUS (JSON — untuk polling frontend) ────────────────────────────────

    /**
     * Kembalikan status sesi QR aktif dalam format JSON.
     *
     * Dipakai oleh halaman scan-qr untuk polling apakah sesi masih aktif
     * tanpa harus reload halaman penuh, dan untuk render QR di frontend.
     *
     * Respons:
     *  - aktif: bool
     *  - kode_qr: string|null  — UUID untuk render QR di frontend
     *  - berakhir_dalam: int|null — detik tersisa sebelum expired
     */
    public function status(Request $request): JsonResponse
    {
        $sesi = SesiQrGuru::aktif()->with('pembuat:id,name')->first();

        if (! $sesi) {
            return response()->json([
                'aktif'          => false,
                'kode_qr'        => null,
                'berakhir_dalam' => null,
            ]);
        }

        $berakhirDalam = $sesi->kadaluarsa_pada
            ? max(0, (int) now()->diffInSeconds($sesi->kadaluarsa_pada, false))
            : null;

        return response()->json([
            'aktif'          => true,
            'sesi_id'        => $sesi->id,
            'kode_qr'        => $sesi->kode_qr,
            'berakhir_dalam' => $berakhirDalam,
            'berlaku_hingga' => $sesi->kadaluarsa_pada?->format('H:i'),
            'dibuka_oleh'    => $sesi->pembuat?->name,
            'dibuka_pada'    => $sesi->berlaku_mulai?->format('H:i'),
        ]);
    }
}