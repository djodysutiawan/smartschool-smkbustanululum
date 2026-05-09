<?php

use Illuminate\Support\Facades\Route;

// ── Guru Controllers ──────────────────────────────────────────────────────────
use App\Http\Controllers\Guru\DashboardController;
use App\Http\Controllers\Guru\JadwalController;
use App\Http\Controllers\Guru\KetersediaanController;
use App\Http\Controllers\Guru\MateriController;
use App\Http\Controllers\Guru\TugasController;
use App\Http\Controllers\Guru\PengumpulanTugasController;
use App\Http\Controllers\Guru\UjianController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\JurnalMengajarController;
use App\Http\Controllers\Guru\AbsensiController;
use App\Http\Controllers\Guru\SesiQrController;
use App\Http\Controllers\Guru\BarcodeKelasController;
use App\Http\Controllers\Guru\RiwayatScanController;
use App\Http\Controllers\Guru\GuruIzinController;
use App\Http\Controllers\Guru\NotifikasiController;
use App\Http\Controllers\Guru\PengumumanController;

Route::prefix('guru')
    ->name('guru.')
    ->middleware(['auth', 'role:guru'])
    ->group(function () {

        // ──────────────────────────────────────────────────────────────────────
        // DASHBOARD
        // ──────────────────────────────────────────────────────────────────────
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ──────────────────────────────────────────────────────────────────────
        // JADWAL MENGAJAR (read-only)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/',         [JadwalController::class, 'index'])->name('index');
            Route::get('/{jadwal}', [JadwalController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // KETERSEDIAAN SAYA
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('ketersediaan')->name('ketersediaan.')->group(function () {
            Route::get('/',                  [KetersediaanController::class, 'index'])->name('index');
            Route::post('/',                 [KetersediaanController::class, 'store'])->name('store');
            Route::put('/{ketersediaan}',    [KetersediaanController::class, 'update'])->name('update');
            Route::delete('/{ketersediaan}', [KetersediaanController::class, 'destroy'])->name('destroy');
        });

        // ──────────────────────────────────────────────────────────────────────
        // MATERI PELAJARAN
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/',                          [MateriController::class, 'index'])->name('index');
            Route::get('/create',                    [MateriController::class, 'create'])->name('create');
            Route::post('/',                         [MateriController::class, 'store'])->name('store');
            Route::get('/{materi}',                  [MateriController::class, 'show'])->name('show');
            Route::get('/{materi}/edit',             [MateriController::class, 'edit'])->name('edit');
            Route::put('/{materi}',                  [MateriController::class, 'update'])->name('update');
            Route::delete('/{materi}',               [MateriController::class, 'destroy'])->name('destroy');
            Route::patch('/{materi}/toggle-publish', [MateriController::class, 'togglePublish'])->name('toggle-publish');
        });

        // ──────────────────────────────────────────────────────────────────────
        // TUGAS
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('tugas')->name('tugas.')->group(function () {
            Route::get('/',                        [TugasController::class, 'index'])->name('index');
            Route::get('/create',                  [TugasController::class, 'create'])->name('create');
            Route::post('/',                       [TugasController::class, 'store'])->name('store');
            Route::get('/{tugas}',                 [TugasController::class, 'show'])->name('show');
            Route::get('/{tugas}/edit',            [TugasController::class, 'edit'])->name('edit');
            Route::put('/{tugas}',                 [TugasController::class, 'update'])->name('update');
            Route::delete('/{tugas}',              [TugasController::class, 'destroy'])->name('destroy');
            Route::patch('/{tugas}/toggle-status', [TugasController::class, 'toggleStatus'])->name('toggle-status');
        });

        // ──────────────────────────────────────────────────────────────────────
        // PENGUMPULAN TUGAS
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('pengumpulan-tugas')->name('pengumpulan-tugas.')->group(function () {
            Route::get('/',                           [PengumpulanTugasController::class, 'index'])->name('index');
            Route::get('/{pengumpulan}',              [PengumpulanTugasController::class, 'show'])->name('show');
            Route::patch('/{pengumpulan}/beri-nilai', [PengumpulanTugasController::class, 'beriNilai'])->name('beri-nilai');
            Route::patch('/{pengumpulan}/kembalikan', [PengumpulanTugasController::class, 'kembalikan'])->name('kembalikan');
        });

        // ──────────────────────────────────────────────────────────────────────
        // UJIAN
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('ujian')->name('ujian.')->group(function () {
            Route::get('/',                        [UjianController::class, 'index'])->name('index');
            Route::get('/create',                  [UjianController::class, 'create'])->name('create');
            Route::post('/',                       [UjianController::class, 'store'])->name('store');

            // Wildcard di bawah
            Route::get('/{ujian}',                 [UjianController::class, 'show'])->name('show');
            Route::get('/{ujian}/edit',            [UjianController::class, 'edit'])->name('edit');
            Route::put('/{ujian}',                 [UjianController::class, 'update'])->name('update');
            Route::delete('/{ujian}',              [UjianController::class, 'destroy'])->name('destroy');
            Route::patch('/{ujian}/toggle-status', [UjianController::class, 'toggleStatus'])->name('toggle-status');
            Route::get('/{ujian}/hasil',           [UjianController::class, 'hasil'])->name('hasil');
        });

        // ──────────────────────────────────────────────────────────────────────
        // NILAI SISWA
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/',             [NilaiController::class, 'index'])->name('index');
            Route::get('/create',       [NilaiController::class, 'create'])->name('create');
            Route::post('/',            [NilaiController::class, 'store'])->name('store');
            Route::get('/{nilai}',      [NilaiController::class, 'show'])->name('show');
            Route::get('/{nilai}/edit', [NilaiController::class, 'edit'])->name('edit');
            Route::put('/{nilai}',      [NilaiController::class, 'update'])->name('update');
            Route::delete('/{nilai}',   [NilaiController::class, 'destroy'])->name('destroy');
        });

        // ──────────────────────────────────────────────────────────────────────
        // JURNAL MENGAJAR
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('jurnal-mengajar')->name('jurnal-mengajar.')->group(function () {
            Route::get('/',              [JurnalMengajarController::class, 'index'])->name('index');
            Route::get('/create',        [JurnalMengajarController::class, 'create'])->name('create');
            Route::post('/',             [JurnalMengajarController::class, 'store'])->name('store');
            Route::get('/{jurnal}',      [JurnalMengajarController::class, 'show'])->name('show');
            Route::get('/{jurnal}/edit', [JurnalMengajarController::class, 'edit'])->name('edit');
            Route::put('/{jurnal}',      [JurnalMengajarController::class, 'update'])->name('update');
            Route::delete('/{jurnal}',   [JurnalMengajarController::class, 'destroy'])->name('destroy');
        });

        // ──────────────────────────────────────────────────────────────────────
        // ABSENSI KELAS
        // Static routes HARUS di atas wildcard /{absensi}
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('absensi')->name('absensi.')->group(function () {

            // ── Static routes ─────────────────────────────────────────────────
            Route::get('/',        [AbsensiController::class, 'index'])->name('index');
            Route::get('/rekap',   [AbsensiController::class, 'rekap'])->name('rekap');
            Route::get('/create',  [AbsensiController::class, 'create'])->name('create');

            // QR Per Pelajaran — daftar jadwal + status sesi QR hari ini
            Route::get('/jadwal',  [AbsensiController::class, 'jadwal'])->name('jadwal');

            // Scan QR oleh guru (verifikasi manual)
            Route::get('/scan',    [AbsensiController::class, 'scan'])->name('scan');
            Route::post('/scan',   [AbsensiController::class, 'prosesScan'])->name('proses-scan');

            // Absensi massal (form satu kelas sekaligus)
            Route::post('/massal', [AbsensiController::class, 'storeMassal'])->name('storeMassal');
            Route::post('/',       [AbsensiController::class, 'store'])->name('store');

            // ── Wildcard routes ───────────────────────────────────────────────
            Route::get('/{absensi}',      [AbsensiController::class, 'show'])->name('show');
            Route::get('/{absensi}/edit', [AbsensiController::class, 'edit'])->name('edit');
            Route::put('/{absensi}',      [AbsensiController::class, 'update'])->name('update');
            Route::delete('/{absensi}',   [AbsensiController::class, 'destroy'])->name('destroy');
        });

        // ──────────────────────────────────────────────────────────────────────
        // SESI QR KELAS (via SesiQrController yang sudah ada)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('sesi-qr')->name('sesi-qr.')->group(function () {
            Route::get('/',                       [SesiQrController::class, 'index'])->name('index');
            Route::get('/create',                 [SesiQrController::class, 'create'])->name('create');
            Route::post('/',                      [SesiQrController::class, 'store'])->name('store');
            Route::get('/{sesiQr}',               [SesiQrController::class, 'show'])->name('show');
            Route::delete('/{sesiQr}',            [SesiQrController::class, 'destroy'])->name('destroy');
            Route::patch('/{sesiQr}/nonaktifkan', [SesiQrController::class, 'nonaktifkan'])->name('nonaktifkan');
            Route::get('/{sesiQr}/cetak-qr',      [SesiQrController::class, 'cetakQr'])->name('cetak-qr');
        });

        // ──────────────────────────────────────────────────────────────────────
        // BARCODE KELAS & BARCODE GURU
        //
        // Dua fungsi utama:
        // 1. Barcode TETAP guru (untuk scan di pos piket absensi guru)
        // 2. QR SESI pelajaran (harus sesuai jadwal hari ini, tidak bisa manual)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('barcode-kelas')->name('barcode-kelas.')->group(function () {

            // ── Static routes (harus di atas wildcard) ────────────────────────

            // Halaman utama: barcode guru + daftar jadwal hari ini
            Route::get('/', [BarcodeKelasController::class, 'index'])->name('index');

            // Cetak barcode tetap guru (tanpa layout)
            Route::get('/cetak-barcode-guru', [BarcodeKelasController::class, 'cetakBarcodeGuru'])->name('cetak-barcode-guru');

            // Form buat sesi QR berdasarkan jadwal
            Route::get('/sesi/create',        [BarcodeKelasController::class, 'createSesi'])->name('create-sesi');
            Route::post('/sesi',              [BarcodeKelasController::class, 'storeSesi'])->name('store-sesi');

            // Tampilkan QR sesi (fullscreen untuk tayangkan ke siswa)
            // Harus sebelum /{kelas} agar tidak ter-overlap
            Route::get('/sesi/{sesiQr}',               [BarcodeKelasController::class, 'showSesi'])->name('show-sesi');
            Route::patch('/sesi/{sesiQr}/nonaktifkan', [BarcodeKelasController::class, 'nonaktifkanSesi'])->name('nonaktifkan-sesi');

            // AJAX: status scan real-time untuk halaman showSesi
            Route::get('/sesi/{sesiQr}/status', [BarcodeKelasController::class, 'statusSesiAjax'])->name('status-sesi-ajax');

            // ── Wildcard /{kelas} ─────────────────────────────────────────────
            // Barcode tetap per kelas (untuk ditempel di papan kelas)
            Route::get('/{kelas}',         [BarcodeKelasController::class, 'show'])->name('show');
            Route::get('/{kelas}/cetak',   [BarcodeKelasController::class, 'cetak'])->name('cetak');
        });

        // ──────────────────────────────────────────────────────────────────────
        // RIWAYAT SCAN (scoped ke sesi QR milik guru ini)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('riwayat-scan')->name('riwayat-scan.')->group(function () {
            Route::get('/',          [RiwayatScanController::class, 'index'])->name('index');
            Route::get('/{riwayat}', [RiwayatScanController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // IZIN KELUAR SISWA (read-only — hanya kelas yang diajar guru ini)
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('izin-keluar-siswa')->name('izin-keluar-siswa.')->group(function () {
            Route::get('/',       [GuruIzinController::class, 'index'])->name('index');
            Route::get('/{izin}', [GuruIzinController::class, 'show'])->name('show');
        });

        // ──────────────────────────────────────────────────────────────────────
        // NOTIFIKASI
        // ──────────────────────────────────────────────────────────────────────
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            // Static routes harus di atas wildcard
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