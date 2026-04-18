<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Piket\DashboardController;
use App\Http\Controllers\Piket\JadwalController;
use App\Http\Controllers\Piket\LogPiketController;
use App\Http\Controllers\Piket\PelanggaranController;
use App\Http\Controllers\Piket\LaporanController;
use App\Http\Controllers\Piket\NotifikasiController;
use App\Http\Controllers\Piket\PengumumanController;

Route::prefix('piket')
    ->name('piket.')
    ->middleware(['auth', 'role:guru_piket'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Jadwal Piket Saya
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [JadwalController::class, 'index'])->name('index');
            Route::get('/{jadwal}', [JadwalController::class, 'show'])->name('show');
        });

        // Check-In / Log Piket
        Route::prefix('log')->name('log.')->group(function () {
            Route::get('/checkin', [LogPiketController::class, 'checkin'])->name('checkin');
            Route::post('/checkin', [LogPiketController::class, 'doCheckin'])->name('do-checkin');
            Route::patch('/{log}/checkout', [LogPiketController::class, 'checkout'])->name('checkout');
        });

        // Pelanggaran Siswa
        Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
            Route::get('/', [PelanggaranController::class, 'index'])->name('index');
            Route::get('/create', [PelanggaranController::class, 'create'])->name('create');
            Route::post('/', [PelanggaranController::class, 'store'])->name('store');
            Route::get('/{pelanggaran}', [PelanggaranController::class, 'show'])->name('show');
            Route::get('/{pelanggaran}/edit', [PelanggaranController::class, 'edit'])->name('edit');
            Route::put('/{pelanggaran}', [PelanggaranController::class, 'update'])->name('update');
            Route::patch('/{pelanggaran}/selesaikan', [PelanggaranController::class, 'selesaikan'])->name('selesaikan');
        });

        // Laporan Harian
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/harian', [LaporanController::class, 'harian'])->name('harian');
            Route::post('/harian', [LaporanController::class, 'simpanHarian'])->name('simpan-harian');
            Route::get('/riwayat', [LaporanController::class, 'riwayat'])->name('riwayat');
            Route::get('/{laporan}', [LaporanController::class, 'show'])->name('show');
        });

        // Notifikasi
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/', [NotifikasiController::class, 'index'])->name('index');
            Route::get('/{notifikasi}', [NotifikasiController::class, 'show'])->name('show');
            Route::patch('/mark-all-read', [NotifikasiController::class, 'markAllRead'])->name('mark-all-read');
            Route::patch('/{notifikasi}/mark-read', [NotifikasiController::class, 'markRead'])->name('mark-read');
            Route::delete('/{notifikasi}', [NotifikasiController::class, 'destroy'])->name('destroy');
        });

        // Pengumuman (read-only)
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/', [PengumumanController::class, 'index'])->name('index');
            Route::get('/{pengumuman}', [PengumumanController::class, 'show'])->name('show');
        });
    });