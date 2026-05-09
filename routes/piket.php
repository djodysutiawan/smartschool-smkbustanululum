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
use App\Http\Controllers\Piket\AbsensiGuruController;
use App\Http\Controllers\Piket\SesiGerbangController;
use App\Http\Controllers\Piket\AbsensiGerbangController;
use App\Http\Controllers\Piket\SesiQrGuruController;

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
            Route::get('/',         [JadwalController::class, 'index'])->name('index');
            Route::get('/{jadwal}', [JadwalController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // CHECK-IN / LOG PIKET
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('log')->name('log.')->group(function () {
            Route::get('/checkin',          [LogPiketController::class, 'checkin'])->name('checkin');
            Route::post('/checkin',         [LogPiketController::class, 'doCheckin'])->name('do-checkin');
            Route::patch('/{log}/checkout', [LogPiketController::class, 'checkout'])->name('checkout');
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
            Route::get('/export-pdf',[LaporanController::class, 'exportPdf'])->name('export-pdf');
        });

        // ──────────────────────────────────────────────────────────────────────
        // ABSENSI SISWA GERBANG — SESI GERBANG
        // Piket sebagai operator utama: buka sesi, pantau, tutup, export arsip.
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('sesi-gerbang')->name('sesi-gerbang.')->group(function () {
            Route::get('/',                       [SesiGerbangController::class, 'index'])->name('index');
            Route::get('/create',                 [SesiGerbangController::class, 'create'])->name('create');
            Route::post('/',                      [SesiGerbangController::class, 'store'])->name('store');
            Route::get('/{sesiGerbang}',          [SesiGerbangController::class, 'show'])->name('show');
            Route::get('/{sesiGerbang}/edit',     [SesiGerbangController::class, 'edit'])->name('edit');
            Route::patch('/{sesiGerbang}',        [SesiGerbangController::class, 'update'])->name('update');

            // Tutup sesi — mengisi ditutup_pada & ditutup_oleh
            Route::patch('/{sesiGerbang}/tutup',  [SesiGerbangController::class, 'tutup'])->name('tutup');

            // Buka kembali sesi hari ini yang salah ditutup
            Route::patch('/{sesiGerbang}/buka',   [SesiGerbangController::class, 'buka'])->name('buka');

            // Export satu sesi ke PDF untuk arsip fisik piket
            Route::get('/{sesiGerbang}/export-pdf', [SesiGerbangController::class, 'exportPdf'])->name('export-pdf');

            // JSON — status sesi aktif (untuk polling live monitor)
            Route::get('/ajax/sesi-aktif', [SesiGerbangController::class, 'ajaxSesiAktif'])->name('ajax-sesi-aktif');
        });

        // ──────────────────────────────────────────────────────────────────────
        // ABSENSI SISWA GERBANG — MONITOR & OPERASIONAL
        // Live monitor, scan manual, rekap harian, belum hadir,
        // koreksi scan, dan webhook dari alat scanner hardware.
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('absensi-gerbang')->name('absensi-gerbang.')->group(function () {

            // Live monitor — SSR awal + polling JSON real-time
            Route::get('/live',         [AbsensiGerbangController::class, 'live'])->name('live');

            // Rekap harian (per tanggal / kelas / tipe)
            Route::get('/rekap',        [AbsensiGerbangController::class, 'rekap'])->name('rekap');

            // Daftar siswa belum hadir hari ini
            Route::get('/belum-hadir',  [AbsensiGerbangController::class, 'belumHadir'])->name('belum-hadir');

            // Scan manual — tanpa alat scanner
            Route::get('/scan-manual',  [AbsensiGerbangController::class, 'scanManual'])->name('scan-manual');
            Route::post('/scan-manual', [AbsensiGerbangController::class, 'prosesScanManual'])->name('proses-scan-manual');

            // Export log harian ke PDF (arsip piket)
            Route::get('/export-pdf',   [AbsensiGerbangController::class, 'exportPdf'])->name('export-pdf');

            // Export daftar belum hadir ke PDF
            Route::get('/belum-hadir/export-pdf', [AbsensiGerbangController::class, 'exportBelumHadirPdf'])->name('belum-hadir-export-pdf');

            // JSON polling untuk live monitor
            Route::get('/ajax-live',    [AbsensiGerbangController::class, 'ajaxLive'])->name('ajax-live');

            // Koreksi tipe scan (masuk → pulang atau sebaliknya)
            Route::post('/{absensiGerbang}/koreksi', [AbsensiGerbangController::class, 'koreksi'])->name('koreksi');

            // Edit catatan & hapus scan (terbatas)
            Route::get('/{absensiGerbang}/edit',  [AbsensiGerbangController::class, 'edit'])->name('edit');
            Route::patch('/{absensiGerbang}',     [AbsensiGerbangController::class, 'update'])->name('update');
            Route::delete('/{absensiGerbang}',    [AbsensiGerbangController::class, 'destroy'])->name('destroy');

            // Endpoint penerima data dari alat scanner hardware (POST dari device)
            // withoutMiddleware: alat tidak punya session Laravel
            Route::post('/webhook', [AbsensiGerbangController::class, 'webhook'])
                ->name('webhook')
                ->withoutMiddleware(['auth', 'role:guru_piket']);
        });

        // ──────────────────────────────────────────────────────────────────────
        // ABSENSI GURU — SESI QR GURU
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('sesi-qr-guru')->name('sesi-qr-guru.')->group(function () {
            Route::get('/',                      [SesiQrGuruController::class, 'index'])->name('index');
            Route::get('/create',                [SesiQrGuruController::class, 'create'])->name('create');
            Route::post('/',                     [SesiQrGuruController::class, 'store'])->name('store');
            Route::get('/aktif',                 [SesiQrGuruController::class, 'aktif'])->name('aktif');
            Route::get('/{sesiQrGuru}',          [SesiQrGuruController::class, 'show'])->name('show');
            Route::get('/{sesiQrGuru}/edit',     [SesiQrGuruController::class, 'edit'])->name('edit');
            Route::patch('/{sesiQrGuru}',        [SesiQrGuruController::class, 'update'])->name('update');
            Route::patch('/{sesiQrGuru}/tutup',  [SesiQrGuruController::class, 'tutup'])->name('tutup');
            Route::patch('/{sesiQrGuru}/refresh',[SesiQrGuruController::class, 'refresh'])->name('refresh');
        });

        // ──────────────────────────────────────────────────────────────────────
        // ABSENSI GURU (input absensi guru lain oleh guru piket)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('absensi-guru')->name('absensi-guru.')->group(function () {
            Route::get('/dashboard', [AbsensiGuruController::class, 'dashboard'])->name('dashboard');

            Route::prefix('massal')->name('massal.')->group(function () {
                Route::get('/form', [AbsensiGuruController::class, 'massalForm'])->name('form');
                Route::post('/',    [AbsensiGuruController::class, 'massalStore'])->name('store');
            });

            Route::get('/riwayat',  [AbsensiGuruController::class, 'riwayat'])->name('riwayat');
            Route::get('/scan-qr',  [AbsensiGuruController::class, 'scanQr'])->name('scan-qr');
            Route::post('/scan-qr', [AbsensiGuruController::class, 'prosesQr'])->name('proses-qr');
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
    });