<?php

namespace App\Http\Controllers\Piket\Concerns;

use App\Models\LogPiket;
use Illuminate\Support\Facades\Auth;

/**
 * Trait PiketActiveGuru
 *
 * Digunakan oleh controller Piket untuk mendapatkan guru_id dari log
 * check-in aktif hari ini, bukan dari Auth::user()->guru_id langsung.
 *
 * Alasan: satu User bisa memiliki relasi guru; tapi hak akses halaman piket
 * dikunci oleh keberadaan LogPiket aktif hari ini (masuk_pada NOT NULL,
 * keluar_pada NULL) agar guru yang belum check-in tidak bisa operasional.
 */
trait PiketActiveGuru
{
    /**
     * Kembalikan guru_id dari log piket aktif hari ini milik user yang login.
     * Return null jika belum check-in atau sudah check-out.
     */
    protected function resolveActiveGuruId(): ?int
    {
        $user = Auth::user();

        // Ambil guru_id dari relasi pengguna → guru (jika ada)
        $guruId = $user->guru?->id ?? null;

        if (! $guruId) {
            return null;
        }

        // Validasi: ada log piket hari ini yang sudah masuk tapi belum keluar
        $logAktif = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->exists();

        return $logAktif ? $guruId : null;
    }

    /**
     * Kembalikan LogPiket aktif hari ini (bukan hanya ID-nya).
     * Berguna jika controller butuh data log (shift, catatan, dll).
     */
    protected function resolveActiveLog(): ?LogPiket
    {
        $user   = Auth::user();
        $guruId = $user->guru?->id ?? null;

        if (! $guruId) {
            return null;
        }

        return LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->latest('masuk_pada')
            ->first();
    }

    /**
     * Redirect ke halaman check-in dengan pesan flash.
     * Digunakan oleh method show() / action() yang butuh guru aktif.
     *
     * @param  string $pesan  Pesan warning yang ditampilkan ke user.
     */
    protected function redirectBelumCheckin(string $pesan = 'Silakan check-in terlebih dahulu.'): \Illuminate\Http\RedirectResponse
    {
        return redirect()
            ->route('piket.log.checkin')
            ->with('warning', $pesan);
    }
}