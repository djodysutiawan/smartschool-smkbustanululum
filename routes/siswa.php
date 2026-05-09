<?php

use Illuminate\Support\Facades\Route;

// ── Siswa Controllers ─────────────────────────────────────────────────────────
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

// ── [BARU] Controllers yang belum ada sebelumnya ──────────────────────────────
use App\Http\Controllers\Siswa\BarcodeController;
use App\Http\Controllers\Siswa\AbsensiGerbangController;

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
            Route::get('/',          [JadwalController::class, 'index'])->name('index');
            Route::get('/{jadwal}',  [JadwalController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // [BARU] BARCODE SAYA
        // Sidebar: "Barcode Saya" — akses cepat dari menu Utama, dipakai tiap hari.
        // Menampilkan 2 jenis:
        //   1. Barcode Tetap  → scan alat gerbang (masuk & pulang), tidak berubah
        //   2. QR Kelas       → absensi per pelajaran (berganti tiap sesi, dibuat guru)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('barcode')->name('barcode.')->group(function () {
            // Halaman utama — tampilkan kedua barcode sekaligus
            Route::get('/',                  [BarcodeController::class, 'index'])->name('index');

            // Tampilkan barcode tetap saja (fullscreen, cocok untuk scan langsung)
            Route::get('/tetap',             [BarcodeController::class, 'tetap'])->name('tetap');

            // Download barcode tetap sebagai gambar (PNG/SVG)
            Route::get('/tetap/download',    [BarcodeController::class, 'download'])->name('download');

            // QR kelas aktif saat ini (berganti per sesi, real-time)
            Route::get('/qr-kelas',          [BarcodeController::class, 'qrKelas'])->name('qr-kelas');
        });

        // ──────────────────────────────────────────────────────────────────────
        // MATERI PELAJARAN (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/',          [MateriController::class, 'index'])->name('index');
            Route::get('/{materi}',  [MateriController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // TUGAS & PENGUMPULAN
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('tugas')->name('tugas.')->group(function () {
            Route::get('/',                  [TugasController::class, 'index'])->name('index');
            Route::get('/{tugas}',           [TugasController::class, 'show'])->name('show');
            Route::post('/{tugas}/kumpul',   [TugasController::class, 'kumpul'])->name('kumpul');
        });

        // ──────────────────────────────────────────────────────────────────────
        // UJIAN ONLINE
        // PENTING: route statis didaftarkan SEBELUM route dengan parameter
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('ujian')->name('ujian.')->group(function () {
            Route::get('/',                             [UjianController::class, 'index'])->name('index');
            Route::get('/riwayat',                      [UjianController::class, 'riwayat'])->name('riwayat');
            Route::get('/{ujian}/mulai',                [UjianController::class, 'mulai'])->name('mulai');
            Route::post('/{ujian}/start',               [UjianController::class, 'start'])->name('start');
            Route::get('/{ujian}/kerjakan',             [UjianController::class, 'kerjakan'])->name('kerjakan');
            Route::post('/{ujian}/soal/{soal}/jawab',   [UjianController::class, 'jawab'])->name('soal.jawab');
            Route::post('/{ujian}/selesai',             [UjianController::class, 'selesai'])->name('selesai');
            Route::get('/{ujian}/hasil',                [UjianController::class, 'hasil'])->name('hasil');
        });

        // ──────────────────────────────────────────────────────────────────────
        // [BARU] ABSENSI GERBANG
        // Sidebar: "Status Hari Ini", "Riwayat Masuk & Pulang"
        // Read-only — siswa hanya melihat data scan gerbangnya sendiri
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('absensi-gerbang')->name('absensi-gerbang.')->group(function () {
            // Status scan masuk & pulang hari ini
            Route::get('/status-hari-ini',   [AbsensiGerbangController::class, 'statusHariIni'])->name('status-hari-ini');

            // Riwayat seluruh log masuk & pulang (dengan filter tanggal)
            Route::get('/riwayat',           [AbsensiGerbangController::class, 'riwayat'])->name('riwayat');

            // Detail satu entri scan (opsional — untuk modal/popup)
            Route::get('/{absensiGerbang}',  [AbsensiGerbangController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // ABSENSI KELAS (scan QR & riwayat)
        // Sidebar: Scan QR Pelajaran, QR Per Pelajaran, Riwayat Absensi Kelas
        // PENTING: semua static routes di atas wildcard
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('absensi')->name('absensi.')->group(function () {
            // [BARU] Status absensi kelas hari ini — sidebar "Status Kelas Hari Ini"
            // (dipakai juga oleh ortu.absensi.status-hari-ini)
            Route::get('/status-hari-ini',   [AbsensiController::class, 'statusHariIni'])->name('status-hari-ini');

            // Scan QR yang ditampilkan guru di layar saat pelajaran
            Route::get('/scan',              [AbsensiController::class, 'scan'])->name('scan');
            Route::post('/scan',             [AbsensiController::class, 'doScan'])->name('do-scan');

            // QR Per Pelajaran — daftar sesi QR aktif hari ini per jadwal
            Route::get('/jadwal',            [AbsensiController::class, 'jadwalHariIni'])->name('jadwal');

            // Riwayat absensi kelas (semua pertemuan)
            Route::get('/riwayat',           [AbsensiController::class, 'riwayat'])->name('riwayat');

            // Rekap kehadiran per bulan / per mapel
            Route::get('/rekap',             [AbsensiController::class, 'rekap'])->name('rekap');
        });

        // ──────────────────────────────────────────────────────────────────────
        // NILAI & RAPOR (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/',          [NilaiController::class, 'index'])->name('index');
            Route::get('/rapor',     [NilaiController::class, 'rapor'])->name('rapor');
        });

        // ──────────────────────────────────────────────────────────────────────
        // KEDISIPLINAN / PELANGGARAN SAYA (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
            Route::get('/',                  [PelanggaranController::class, 'index'])->name('index');
            Route::get('/{pelanggaran}',     [PelanggaranController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // NOTIFIKASI
        // PENTING: 'mark-all-read' harus di atas '/{notifikasi}'
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