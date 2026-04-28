<?php

namespace App\Http\Controllers\Piket\Concerns;

use App\Models\LogPiket;
use Illuminate\Support\Facades\Auth;

/**
 * Trait ini dipakai oleh semua controller piket.
 *
 * Karena 1 akun guru_piket dipakai bergantian oleh banyak guru,
 * identitas "siapa yang sedang bertugas" ditentukan dari log check-in
 * aktif hari ini (masuk_pada != null, keluar_pada == null),
 * BUKAN dari Auth::user()->guru.
 */
trait PiketActiveGuru
{
    /**
     * Ambil guru_id dari log check-in aktif hari ini.
     * Jika belum check-in, return null.
     */
    protected function resolveActiveGuruId(): ?int
    {
        return $this->resolveActiveLog()?->guru_id;
    }

    /**
     * Ambil LogPiket aktif hari ini.
     * "Aktif" = masuk_pada tidak null, keluar_pada null.
     */
    protected function resolveActiveLog(): ?LogPiket
    {
        return LogPiket::whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->latest('masuk_pada')
            ->first();
    }

    /**
     * Ambil instance Guru dari log aktif.
     */
    protected function resolveActiveGuru(): ?\App\Models\Guru
    {
        return $this->resolveActiveLog()?->guru;
    }

    /**
     * Redirect ke halaman check-in dengan pesan error.
     * Dipanggil saat guru belum check-in tapi mencoba akses fitur.
     */
    protected function redirectBelumCheckin(string $pesan = null)
    {
        return redirect()->route('piket.log.checkin')
            ->with('warning', $pesan ?? 'Anda harus check-in terlebih dahulu sebelum menggunakan fitur ini.');
    }
}