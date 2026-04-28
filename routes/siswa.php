<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\JadwalController;
use App\Http\Controllers\Siswa\MateriController;
use App\Http\Controllers\Siswa\TugasController;
use App\Http\Controllers\Siswa\UjianController;
use App\Http\Controllers\Siswa\AbsensiController;
use App\Http\Controllers\Siswa\NilaiController;
use App\Http\Controllers\Siswa\PelanggaranController;
use App\Http\Controllers\Siswa\NotifikasiController;
use App\Http\Controllers\Siswa\PengumumanController;

Route::prefix('siswa')
    ->name('siswa.')
    ->middleware(['auth', 'role:siswa'])
    ->group(function () {

        // ──────────────────────────────────────────────────────────────────────
        // DASHBOARD
        // ──────────────────────────────────────────────────────────────────────
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ──────────────────────────────────────────────────────────────────────
        // JADWAL PELAJARAN (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/',           [JadwalController::class, 'index'])->name('index');
            Route::get('/{jadwal}',   [JadwalController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // MATERI (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/',           [MateriController::class, 'index'])->name('index');
            Route::get('/{materi}',   [MateriController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // TUGAS & PENGUMPULAN
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('tugas')->name('tugas.')->group(function () {
            Route::get('/',                     [TugasController::class, 'index'])->name('index');
            Route::get('/{tugas}',              [TugasController::class, 'show'])->name('show');
            Route::post('/{tugas}/kumpul',      [TugasController::class, 'kumpul'])->name('kumpul');
        });

        // ──────────────────────────────────────────────────────────────────────
        // UJIAN ONLINE
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('ujian')->name('ujian.')->group(function () {
            // PENTING: route statis didaftarkan SEBELUM route dengan parameter
            Route::get('/',                                 [UjianController::class, 'index'])->name('index');
            Route::get('/riwayat',                          [UjianController::class, 'riwayat'])->name('riwayat');
            Route::get('/{ujian}/mulai',                    [UjianController::class, 'mulai'])->name('mulai');
            Route::post('/{ujian}/start',                   [UjianController::class, 'start'])->name('start');
            Route::get('/{ujian}/kerjakan',                 [UjianController::class, 'kerjakan'])->name('kerjakan');
            Route::post('/{ujian}/soal/{soal}/jawab',       [UjianController::class, 'jawab'])->name('soal.jawab');
            Route::post('/{ujian}/selesai',                 [UjianController::class, 'selesai'])->name('selesai');
            Route::get('/{ujian}/hasil',                    [UjianController::class, 'hasil'])->name('hasil');
        });

        // ──────────────────────────────────────────────────────────────────────
        // ABSENSI (scan QR & riwayat)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('absensi')->name('absensi.')->group(function () {
            // PENTING: route statis sebelum parameter
            Route::get('/scan',     [AbsensiController::class, 'scan'])->name('scan');
            Route::post('/scan',    [AbsensiController::class, 'doScan'])->name('do-scan');
            Route::get('/riwayat',  [AbsensiController::class, 'riwayat'])->name('riwayat');
            Route::get('/rekap',    [AbsensiController::class, 'rekap'])->name('rekap');
        });

        // ──────────────────────────────────────────────────────────────────────
        // NILAI & RAPOR (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/',         [NilaiController::class, 'index'])->name('index');
            Route::get('/rapor',    [NilaiController::class, 'rapor'])->name('rapor');
        });

        // ──────────────────────────────────────────────────────────────────────
        // KEDISIPLINAN / PELANGGARAN SAYA (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
            Route::get('/',                     [PelanggaranController::class, 'index'])->name('index');
            Route::get('/{pelanggaran}',        [PelanggaranController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // NOTIFIKASI
        // PENTING: 'mark-all-read' harus didaftarkan SEBELUM '/{notifikasi}'
        // agar tidak terdeteksi sebagai route parameter.
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::patch('/mark-all-read',              [NotifikasiController::class, 'markAllRead'])->name('mark-all-read');
            Route::get('/',                             [NotifikasiController::class, 'index'])->name('index');
            Route::get('/{notifikasi}',                 [NotifikasiController::class, 'show'])->name('show');
            Route::patch('/{notifikasi}/mark-read',     [NotifikasiController::class, 'markRead'])->name('mark-read');
            Route::delete('/{notifikasi}',              [NotifikasiController::class, 'destroy'])->name('destroy');
        });

        // ──────────────────────────────────────────────────────────────────────
        // PENGUMUMAN (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/',                 [PengumumanController::class, 'index'])->name('index');
            Route::get('/{pengumuman}',     [PengumumanController::class, 'show'])->name('show');
        });
    });