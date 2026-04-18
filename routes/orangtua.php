<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrangTua\DashboardController;
use App\Http\Controllers\OrangTua\ProfilAnakController;
use App\Http\Controllers\OrangTua\AkademikController;
use App\Http\Controllers\OrangTua\AbsensiController;
use App\Http\Controllers\OrangTua\KedisiplinanController;
use App\Http\Controllers\OrangTua\NotifikasiController;
use App\Http\Controllers\OrangTua\PengumumanController;

Route::prefix('ortu')
    ->name('ortu.')
    ->middleware(['auth', 'role:orang_tua'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profil Anak
        Route::prefix('profil-anak')->name('profil-anak.')->group(function () {
            Route::get('/', [ProfilAnakController::class, 'index'])->name('index');
            Route::get('/{siswa}', [ProfilAnakController::class, 'show'])->name('show');
        });

        // Akademik Anak (read-only)
        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/nilai', [AkademikController::class, 'nilai'])->name('nilai');
            Route::get('/rapor', [AkademikController::class, 'rapor'])->name('rapor');
            Route::get('/tugas', [AkademikController::class, 'tugas'])->name('tugas');
        });

        // Kehadiran Anak (read-only)
        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('/status-hari-ini', [AbsensiController::class, 'statusHariIni'])->name('status-hari-ini');
            Route::get('/riwayat', [AbsensiController::class, 'riwayat'])->name('riwayat');
            Route::get('/rekap', [AbsensiController::class, 'rekap'])->name('rekap');
        });

        // Kedisiplinan Anak (read-only)
        Route::prefix('kedisiplinan')->name('kedisiplinan.')->group(function () {
            Route::get('/riwayat', [KedisiplinanController::class, 'riwayat'])->name('riwayat');
            Route::get('/total-poin', [KedisiplinanController::class, 'totalPoin'])->name('total-poin');
            Route::get('/status', [KedisiplinanController::class, 'status'])->name('status');
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