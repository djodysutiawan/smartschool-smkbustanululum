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
 * Alasan: satu User punya relasi guru; tapi hak akses halaman piket
 * dikunci oleh keberadaan LogPiket aktif hari ini (masuk_pada NOT NULL,
 * keluar_pada NULL) agar guru yang belum check-in tidak bisa operasional.
 *
 * FIX: Ditambahkan request-level caching via property `$_resolvedGuruId` dan
 * `$_resolvedLog` agar query tidak diulang jika dipanggil lebih dari sekali
 * dalam satu request (misalnya di index() yang memanggil resolveActiveGuruId()
 * sebelum query utama).
 */
trait PiketActiveGuru
{
    /**
     * Cache guru_id yang sudah di-resolve untuk request ini.
     * Nilai `false` berarti "belum di-resolve", null berarti "tidak ada log aktif".
     */
    private int|null|false $_resolvedGuruId = false;

    /**
     * Cache LogPiket aktif yang sudah di-resolve untuk request ini.
     */
    private LogPiket|null|false $_resolvedLog = false;

    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Kembalikan guru_id dari log piket aktif hari ini milik user yang login.
     * Return null jika belum check-in atau sudah check-out.
     *
     * Query hanya dijalankan sekali per request (di-cache di property).
     */
    protected function resolveActiveGuruId(): ?int
    {
        if ($this->_resolvedGuruId !== false) {
            return $this->_resolvedGuruId;
        }

        $user   = Auth::user();
        $guruId = $user->guru?->id ?? null;

        if (! $guruId) {
            return $this->_resolvedGuruId = null;
        }

        // Validasi: ada log piket hari ini yang sudah masuk tapi belum keluar.
        $logAktif = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->exists();

        $this->_resolvedGuruId = $logAktif ? $guruId : null;

        return $this->_resolvedGuruId;
    }

    /**
     * Kembalikan LogPiket aktif hari ini (bukan hanya ID-nya).
     * Berguna jika controller butuh data log (shift, catatan, dll).
     *
     * Query hanya dijalankan sekali per request (di-cache di property).
     */
    protected function resolveActiveLog(): ?LogPiket
    {
        if ($this->_resolvedLog !== false) {
            return $this->_resolvedLog;
        }

        $user   = Auth::user();
        $guruId = $user->guru?->id ?? null;

        if (! $guruId) {
            return $this->_resolvedLog = null;
        }

        $this->_resolvedLog = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->latest('masuk_pada')
            ->first();

        // Sinkronkan _resolvedGuruId jika belum di-resolve
        if ($this->_resolvedGuruId === false) {
            $this->_resolvedGuruId = $this->_resolvedLog?->guru_id ?? null;
        }

        return $this->_resolvedLog;
    }

    /**
     * Redirect ke halaman check-in dengan pesan flash warning.
     * Digunakan oleh method show() / action() yang butuh guru aktif.
     */
    protected function redirectBelumCheckin(
        string $pesan = 'Silakan check-in terlebih dahulu.'
    ): \Illuminate\Http\RedirectResponse {
        return redirect()
            ->route('piket.log.checkin')
            ->with('warning', $pesan);
    }
}