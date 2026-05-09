<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\SesiQrGuru;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * SesiQrGuruController (Piket)
 *
 * Digunakan oleh role 'guru_piket' untuk mengelola sesi QR absensi guru.
 *
 * Tanggung jawab controller ini:
 *  - Membuka sesi QR baru (jika belum ada yang aktif)
 *  - Menutup sesi QR yang sedang aktif
 *  - Me-refresh token QR yang sedang aktif (agar QR tidak bisa dipakai ulang)
 *  - Menampilkan halaman sesi QR aktif beserta QR code-nya
 *
 * Batasan piket vs admin:
 *  - Piket TIDAK bisa melihat riwayat sesi QR lama (hanya admin)
 *  - Piket TIDAK bisa mengubah durasi / konfigurasi sesi (hanya admin)
 *  - Piket hanya bisa membuka 1 sesi aktif dalam satu waktu
 *  - Sesi yang dibuka piket otomatis menutup diri setelah batas waktu
 *    yang dikonfigurasi admin (via SesiQrGuru::$defaultDurasi)
 *
 * Token QR:
 *  - Format payload: "{sesi_id}:{guru_id}:{token}"
 *  - Token di-refresh tiap kali piket tekan "Refresh QR" agar QR lama
 *    tidak bisa dipakai oleh guru yang screenshot QR sebelumnya
 *  - Validasi token ada di AbsensiGuruController@prosesQr
 *
 * Views: resources/views/piket/sesi-qr-guru/
 */
class SesiQrGuruController extends Controller
{
    private const VIEW_PREFIX = 'piket.sesi-qr-guru.';

    // ── HALAMAN UTAMA ─────────────────────────────────────────────────────────

    /**
     * Tampilkan status sesi QR guru saat ini.
     *
     * Piket melihat:
     *  - Apakah sesi QR sedang aktif
     *  - QR code yang bisa di-scan guru (jika aktif)
     *  - Tombol buka / tutup / refresh sesi
     *  - Info singkat: dibuka oleh siapa, jam berapa, berakhir kapan
     */
    public function index(): View
    {
        $sesiAktif = SesiQrGuru::aktif()
            ->with('dibukaOleh:id,name')
            ->first();

        return view(self::VIEW_PREFIX . 'index', compact('sesiAktif'));
    }

    // ── BUKA SESI ─────────────────────────────────────────────────────────────

    /**
     * Buka sesi QR baru.
     *
     * Guard:
     *  - Tolak jika sudah ada sesi aktif (piket harus tutup dulu)
     *  - Token di-generate ulang tiap sesi agar tidak bisa ditebak
     *
     * Setelah berhasil, redirect ke index agar QR langsung tampil.
     */
    public function buka(Request $request): RedirectResponse
    {
        // Tolak jika sudah ada sesi yang aktif
        if (SesiQrGuru::aktif()->exists()) {
            return redirect()->route('piket.sesi-qr-guru.index')
                ->with('warning', 'Sesi QR sudah aktif. Tutup sesi sekarang sebelum membuka yang baru.');
        }

        SesiQrGuru::create([
            'token'        => Str::random(64),
            'dibuka_oleh'  => Auth::id(),
            'dibuka_pada'  => now(),
            // berakhir_pada diisi oleh model (boot/creating) sesuai konfigurasi durasi
        ]);

        return redirect()->route('piket.sesi-qr-guru.index')
            ->with('success', 'Sesi QR berhasil dibuka. Guru sekarang bisa scan QR untuk absen.');
    }

    // ── TUTUP SESI ────────────────────────────────────────────────────────────

    /**
     * Tutup sesi QR yang sedang aktif.
     *
     * Piket bisa menutup sesi lebih awal (misalnya setelah jam masuk selesai)
     * agar guru tidak bisa scan QR lagi di luar jam yang seharusnya.
     *
     * Guard:
     *  - Tolak jika tidak ada sesi aktif (tidak ada yang perlu ditutup)
     */
    public function tutup(Request $request): RedirectResponse
    {
        $sesiAktif = SesiQrGuru::aktif()->first();

        if (! $sesiAktif) {
            return redirect()->route('piket.sesi-qr-guru.index')
                ->with('warning', 'Tidak ada sesi QR yang sedang aktif.');
        }

        // Tandai sesi sebagai ditutup manual (bukan expired otomatis)
        $sesiAktif->update([
            'ditutup_pada'   => now(),
            'ditutup_oleh'   => Auth::id(),
            'ditutup_manual' => true,
        ]);

        return redirect()->route('piket.sesi-qr-guru.index')
            ->with('success', 'Sesi QR berhasil ditutup. Guru tidak bisa scan QR lagi.');
    }

    // ── REFRESH TOKEN ─────────────────────────────────────────────────────────

    /**
     * Refresh token sesi QR yang sedang aktif.
     *
     * Digunakan ketika piket curiga QR sudah di-screenshot oleh orang yang
     * tidak berhak, atau setelah jeda tertentu agar QR tidak disalahgunakan.
     *
     * Efek:
     *  - Token lama langsung tidak valid (hash_equals di prosesQr akan gagal)
     *  - QR di layar piket otomatis berubah (reload halaman / polling)
     *
     * Guard:
     *  - Tolak jika tidak ada sesi aktif
     */
    public function refreshToken(Request $request): RedirectResponse
    {
        $sesiAktif = SesiQrGuru::aktif()->first();

        if (! $sesiAktif) {
            return redirect()->route('piket.sesi-qr-guru.index')
                ->with('warning', 'Tidak ada sesi QR aktif yang bisa di-refresh.');
        }

        $sesiAktif->update([
            'token'             => Str::random(64),
            'token_direfresh_pada' => now(),
            'direfresh_oleh'    => Auth::id(),
        ]);

        return redirect()->route('piket.sesi-qr-guru.index')
            ->with('success', 'Token QR berhasil di-refresh. QR lama sudah tidak valid.');
    }

    // ── STATUS (JSON — untuk polling frontend) ────────────────────────────────

    /**
     * Kembalikan status sesi QR aktif dalam format JSON.
     *
     * Dipakai oleh halaman scan-qr (AbsensiGuruController@scanQr) untuk
     * polling apakah sesi masih aktif tanpa harus reload halaman penuh.
     *
     * Respons:
     *  - aktif: bool
     *  - token: string|null  — hanya jika aktif, untuk render QR di frontend
     *  - berakhir_dalam: int|null — detik tersisa sebelum sesi expired
     */
    public function status(Request $request): \Illuminate\Http\JsonResponse
    {
        $sesi = SesiQrGuru::aktif()->first();

        if (! $sesi) {
            return response()->json(['aktif' => false, 'token' => null, 'berakhir_dalam' => null]);
        }

        $berakhirDalam = $sesi->berakhir_pada
            ? max(0, now()->diffInSeconds($sesi->berakhir_pada, false))
            : null;

        return response()->json([
            'aktif'          => true,
            'sesi_id'        => $sesi->id,
            'token'          => $sesi->token,
            'berakhir_dalam' => $berakhirDalam,
            'dibuka_oleh'    => $sesi->dibukaOleh?->name,
            'dibuka_pada'    => $sesi->dibuka_pada?->toIso8601String(),
        ]);
    }
}