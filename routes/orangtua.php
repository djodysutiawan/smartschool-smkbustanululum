<?php

use Illuminate\Support\Facades\Route;

// ── OrangTua Controllers ──────────────────────────────────────────────────────
use App\Http\Controllers\OrangTua\DashboardController;
use App\Http\Controllers\OrangTua\ProfilAnakController;
use App\Http\Controllers\OrangTua\AkademikController;
use App\Http\Controllers\OrangTua\AbsensiController;
use App\Http\Controllers\OrangTua\KedisiplinanController;
use App\Http\Controllers\OrangTua\NotifikasiController;
use App\Http\Controllers\OrangTua\PengumumanController;

// ── [BARU] Controller yang belum ada sebelumnya ───────────────────────────────
use App\Http\Controllers\OrangTua\KehadiranGerbangController;

Route::prefix('ortu')
    ->name('ortu.')
    ->middleware(['auth', 'role:orang_tua'])
    ->group(function () {

        // ──────────────────────────────────────────────────────────────────────
        // DASHBOARD
        // ──────────────────────────────────────────────────────────────────────
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ──────────────────────────────────────────────────────────────────────
        // PROFIL ANAK
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('profil-anak')->name('profil-anak.')->group(function () {
            Route::get('/',          [ProfilAnakController::class, 'index'])->name('index');
            Route::get('/{siswa}',   [ProfilAnakController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // AKADEMIK ANAK (read-only)
        // Sidebar: Nilai per Mapel, Rekap/Rapor, Progress Tugas
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/nilai',  [AkademikController::class, 'nilai'])->name('nilai');
            Route::get('/rapor',  [AkademikController::class, 'rapor'])->name('rapor');
            Route::get('/tugas',  [AkademikController::class, 'tugas'])->name('tugas');
        });

        // ──────────────────────────────────────────────────────────────────────
        // [BARU] KEHADIRAN GERBANG ANAK (read-only)
        // Sidebar: "Status Gerbang Hari Ini"
        // Orang tua melihat apakah anak sudah scan masuk/pulang di gerbang
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('kehadiran-gerbang')->name('kehadiran-gerbang.')->group(function () {
            // Status scan masuk & pulang anak hari ini
            Route::get('/status-hari-ini',   [KehadiranGerbangController::class, 'statusHariIni'])->name('status-hari-ini');

            // Riwayat seluruh log gerbang anak (filter tanggal/bulan)
            Route::get('/riwayat',           [KehadiranGerbangController::class, 'riwayat'])->name('riwayat');

            // Rekap bulanan kehadiran gerbang
            Route::get('/rekap',             [KehadiranGerbangController::class, 'rekap'])->name('rekap');
        });

        // ──────────────────────────────────────────────────────────────────────
        // KEHADIRAN KELAS ANAK (read-only)
        // Sidebar: Status Kelas Hari Ini, Riwayat Kehadiran, Rekap Bulanan
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('/status-hari-ini',   [AbsensiController::class, 'statusHariIni'])->name('status-hari-ini');
            Route::get('/riwayat',           [AbsensiController::class, 'riwayat'])->name('riwayat');
            Route::get('/rekap',             [AbsensiController::class, 'rekap'])->name('rekap');
        });

        // ──────────────────────────────────────────────────────────────────────
        // KEDISIPLINAN ANAK (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('kedisiplinan')->name('kedisiplinan.')->group(function () {
            Route::get('/riwayat',     [KedisiplinanController::class, 'riwayat'])->name('riwayat');
            Route::get('/total-poin',  [KedisiplinanController::class, 'totalPoin'])->name('total-poin');
            Route::get('/status',      [KedisiplinanController::class, 'status'])->name('status');
        });

        // ──────────────────────────────────────────────────────────────────────
        // NOTIFIKASI
        // FIX: 'mark-all-read' harus di atas '/{notifikasi}' agar tidak
        // ter-match sebagai wildcard parameter (bug di file lama).
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::patch('/mark-all-read',           [NotifikasiController::class, 'markAllRead'])->name('mark-all-read');
            Route::get('/',                          [NotifikasiController::class, 'index'])->name('index');
            Route::get('/{notifikasi}',              [NotifikasiController::class, 'show'])->name('show');
            Route::patch('/{notifikasi}/mark-read',  [NotifikasiController::class, 'markRead'])->name('mark-read');
            Route::delete('/{notifikasi}',           [NotifikasiController::class, 'destroy'])->name('destroy');
        });

        // ──────────────────────────────────────────────────────────────────────
        // PENGUMUMAN (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/',              [PengumumanController::class, 'index'])->name('index');
            Route::get('/{pengumuman}',  [PengumumanController::class, 'show'])->name('show');
        });
    });