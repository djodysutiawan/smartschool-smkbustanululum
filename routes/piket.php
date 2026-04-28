<?php

use Illuminate\Support\Facades\Route;

// ── Piket Controllers ─────────────────────────────────────────────────────────
use App\Http\Controllers\Piket\DashboardController;
use App\Http\Controllers\Piket\JadwalController;
use App\Http\Controllers\Piket\LogPiketController;
use App\Http\Controllers\Piket\PelanggaranController;
use App\Http\Controllers\Piket\IzinKeluarSiswaController;
use App\Http\Controllers\Piket\LaporanController;
use App\Http\Controllers\Piket\NotifikasiController;
use App\Http\Controllers\Piket\PengumumanController;
use App\Http\Controllers\Piket\AbsensiGuruController; // ← sekarang di namespace Piket

Route::prefix('piket')
    ->name('piket.')
    ->middleware(['auth', 'role:guru_piket'])
    ->group(function () {

        // ──────────────────────────────────────────────────────────────────────
        // DASHBOARD
        // ──────────────────────────────────────────────────────────────────────
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ──────────────────────────────────────────────────────────────────────
        // JADWAL PIKET SAYA (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [JadwalController::class, 'index'])->name('index');
            Route::get('/{jadwal}', [JadwalController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // CHECK-IN / LOG PIKET
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('log')->name('log.')->group(function () {
            Route::get('/checkin',              [LogPiketController::class, 'checkin'])->name('checkin');
            Route::post('/checkin',             [LogPiketController::class, 'doCheckin'])->name('do-checkin');
            Route::patch('/{log}/checkout',     [LogPiketController::class, 'checkout'])->name('checkout');
        });

        // ──────────────────────────────────────────────────────────────────────
        // PELANGGARAN SISWA
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
            Route::get('/',                           [PelanggaranController::class, 'index'])->name('index');
            Route::get('/create',                     [PelanggaranController::class, 'create'])->name('create');
            Route::post('/',                          [PelanggaranController::class, 'store'])->name('store');
            Route::get('/{pelanggaran}',              [PelanggaranController::class, 'show'])->name('show');
            Route::get('/{pelanggaran}/edit',         [PelanggaranController::class, 'edit'])->name('edit');
            Route::put('/{pelanggaran}',              [PelanggaranController::class, 'update'])->name('update');
            Route::patch('/{pelanggaran}/selesaikan', [PelanggaranController::class, 'selesaikan'])->name('selesaikan');
        });

        // ──────────────────────────────────────────────────────────────────────
        // IZIN KELUAR SISWA
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('izin-keluar-siswa')->name('izin-keluar-siswa.')->group(function () {
            Route::get('/',                                       [IzinKeluarSiswaController::class, 'index'])->name('index');
            Route::get('/create',                                 [IzinKeluarSiswaController::class, 'create'])->name('create');
            Route::post('/',                                      [IzinKeluarSiswaController::class, 'store'])->name('store');
            Route::get('/{izinKeluarSiswa}',                      [IzinKeluarSiswaController::class, 'show'])->name('show');
            Route::get('/{izinKeluarSiswa}/edit',                 [IzinKeluarSiswaController::class, 'edit'])->name('edit');
            Route::patch('/{izinKeluarSiswa}',                    [IzinKeluarSiswaController::class, 'update'])->name('update');
            Route::delete('/{izinKeluarSiswa}',                   [IzinKeluarSiswaController::class, 'destroy'])->name('destroy');
            Route::patch('/{izinKeluarSiswa}/approve',            [IzinKeluarSiswaController::class, 'approve'])->name('approve');
            Route::patch('/{izinKeluarSiswa}/tolak',              [IzinKeluarSiswaController::class, 'tolak'])->name('tolak');
            Route::patch('/{izinKeluarSiswa}/konfirmasi-kembali', [IzinKeluarSiswaController::class, 'konfirmasiKembali'])->name('konfirmasi-kembali');
            Route::get('/{izinKeluarSiswa}/cetak-surat',          [IzinKeluarSiswaController::class, 'cetakSurat'])->name('cetak-surat');
        });

        // ──────────────────────────────────────────────────────────────────────
        // LAPORAN HARIAN
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/harian',    [LaporanController::class, 'harian'])->name('harian');
            Route::post('/harian',   [LaporanController::class, 'simpanHarian'])->name('simpan-harian');
            Route::get('/riwayat',   [LaporanController::class, 'riwayat'])->name('riwayat');
            Route::get('/{laporan}', [LaporanController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // NOTIFIKASI
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::patch('/mark-all-read',          [NotifikasiController::class, 'markAllRead'])->name('mark-all-read');
            Route::get('/',                         [NotifikasiController::class, 'index'])->name('index');
            Route::get('/{notifikasi}',             [NotifikasiController::class, 'show'])->name('show');
            Route::patch('/{notifikasi}/mark-read', [NotifikasiController::class, 'markRead'])->name('mark-read');
            Route::delete('/{notifikasi}',          [NotifikasiController::class, 'destroy'])->name('destroy');
        });

        // ──────────────────────────────────────────────────────────────────────
        // PENGUMUMAN (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/',             [PengumumanController::class, 'index'])->name('index');
            Route::get('/{pengumuman}', [PengumumanController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // ABSENSI GURU (input absensi guru lain oleh guru piket)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('absensi-guru')->name('absensi-guru.')->group(function () {
            Route::get('/dashboard',  [AbsensiGuruController::class, 'dashboard'])->name('dashboard');

            Route::prefix('massal')->name('massal.')->group(function () {
                Route::get('/form',   [AbsensiGuruController::class, 'massalForm'])->name('form');
                Route::post('/',      [AbsensiGuruController::class, 'massalStore'])->name('store');
            });

            Route::get('/riwayat',    [AbsensiGuruController::class, 'riwayat'])->name('riwayat');
            Route::get('/scan-qr',    [AbsensiGuruController::class, 'scanQr'])->name('scan-qr');
            Route::post('/scan-qr',   [AbsensiGuruController::class, 'prosesQr'])->name('proses-qr');
        });
    });