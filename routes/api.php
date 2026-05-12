<?php

use App\Http\Controllers\Api\Auth\AuthController;

// ── Siswa ──────────────────────────────────────────────────────────────────
use App\Http\Controllers\Api\Siswa\AbsensiController       as SiswaAbsensiController;
use App\Http\Controllers\Api\Siswa\BarcodeController       as SiswaBarcodeController;
use App\Http\Controllers\Api\Siswa\DashboardController     as SiswaDashboardController;
use App\Http\Controllers\Api\Siswa\JadwalController        as SiswaJadwalController;
use App\Http\Controllers\Api\Siswa\MateriController        as SiswaMateriController;
use App\Http\Controllers\Api\Siswa\NilaiController         as SiswaNilaiController;
use App\Http\Controllers\Api\Siswa\NotifikasiController    as SiswaNotifikasiController;
use App\Http\Controllers\Api\Siswa\PelanggaranController   as SiswaPelanggaranController;
use App\Http\Controllers\Api\Siswa\PengumumanController    as SiswaPengumumanController;
use App\Http\Controllers\Api\Siswa\TugasController         as SiswaTugasController;
use App\Http\Controllers\Api\Siswa\UjianController         as SiswaUjianController;
use App\Http\Controllers\Api\Siswa\AbsensiGerbangController as SiswaAbsensiGerbangController;

// ── Orang Tua ──────────────────────────────────────────────────────────────
use App\Http\Controllers\Api\OrangTua\AbsensiController          as OrangTuaAbsensiController;
use App\Http\Controllers\Api\OrangTua\AkademikController         as OrangTuaAkademikController;
use App\Http\Controllers\Api\OrangTua\DashboardController        as OrangTuaDashboardController;
use App\Http\Controllers\Api\OrangTua\KehadiranGerbangController as OrangTuaKehadiranGerbangController;
use App\Http\Controllers\Api\OrangTua\KedisiplinanController;
use App\Http\Controllers\Api\OrangTua\NotifikasiController       as OrangTuaNotifikasiController;
use App\Http\Controllers\Api\OrangTua\PengumumanController       as OrangTuaPengumumanController;
use App\Http\Controllers\Api\OrangTua\ProfilAnakController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ── Health check (publik) ──────────────────────────────────────────────────
Route::get('ping', fn () => response()->json([
    'status'  => 'ok',
    'service' => config('app.name'),
    'version' => '1.0.0',
    'time'    => now()->toIso8601String(),
]));

// ── Auth publik ────────────────────────────────────────────────────────────
Route::prefix('auth')->name('api.auth.')->group(function () {
    Route::post('login',    [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

// ── Auth butuh token ───────────────────────────────────────────────────────
Route::prefix('auth')->name('api.auth.')->middleware('auth:sanctum')->group(function () {
    Route::get('me',          [AuthController::class, 'me'])->name('me');
    Route::put('profile',     [AuthController::class, 'updateProfile'])->name('profile');
    Route::put('password',    [AuthController::class, 'updatePassword'])->name('password');
    Route::post('avatar',     [AuthController::class, 'uploadAvatar'])->name('avatar');
    Route::post('logout',     [AuthController::class, 'logout'])->name('logout');
    Route::post('logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');
});

// ── Serve file storage via API ─────────────────────────────────────────────
Route::middleware(['throttle:120,1'])->group(function () {

    Route::get('/file/{path}', [AuthController::class, 'serveFile'])
        ->where('path', '.*')
        ->name('api.file.serve');

    Route::options('/file/{path}', function () {
        return response('', 204, [
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => '*',
            'Access-Control-Max-Age'       => '86400',
        ]);
    })->where('path', '.*');

});

// ── Protected routes ───────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // ══════════════════════════════════════════════════════════════════════
    // SISWA
    // ══════════════════════════════════════════════════════════════════════
    Route::prefix('siswa')->middleware('role:siswa')->name('api.siswa.')->group(function () {

        // Dashboard
        Route::get('dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

        // ── Absensi Mapel ──────────────────────────────────────────────────
        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('status-hari-ini', [SiswaAbsensiController::class, 'statusHariIni'])->name('status-hari-ini');
            Route::post('scan',           [SiswaAbsensiController::class, 'prosesQr'])->name('scan');
            Route::get('riwayat',         [SiswaAbsensiController::class, 'riwayat'])->name('riwayat');
            Route::get('rekap',           [SiswaAbsensiController::class, 'rekap'])->name('rekap');
            Route::get('jadwal',          [SiswaAbsensiController::class, 'jadwalHariIni'])->name('jadwal');
        });

        // ── Absensi Gerbang (read-only) ────────────────────────────────────
        // CATATAN: route statis ({status-hari-ini}, {riwayat}) harus di atas
        // wildcard {id} agar tidak tertangkap route parameter.
        Route::prefix('absensi-gerbang')->name('absensi-gerbang.')->group(function () {
            Route::get('status-hari-ini', [SiswaBarcodeController::class, 'statusGerbangHariIni'])->name('status-hari-ini');
            Route::get('riwayat',         [SiswaBarcodeController::class, 'riwayatGerbang'])->name('riwayat');
            Route::get('{absensiGerbangId}', [SiswaBarcodeController::class, 'showGerbang'])->name('show')
                ->where('absensiGerbangId', '[0-9]+');
        });

        // ── Absensi Gerbang ─────────────────────────────────────────────────────────
        // PENTING: route statis (status-hari-ini, riwayat) HARUS di atas wildcard {absensiGerbangId}
        Route::prefix('absensi-gerbang')->name('absensi-gerbang.')->group(function () {
            Route::get('status-hari-ini', [SiswaAbsensiGerbangController::class, 'statusHariIni'])->name('status-hari-ini');
            Route::get('riwayat',         [SiswaAbsensiGerbangController::class, 'riwayat'])->name('riwayat');
            Route::get('{absensiGerbangId}', [SiswaAbsensiGerbangController::class, 'show'])->name('show')
                ->where('absensiGerbangId', '[0-9]+');
        });

        // ── Barcode ────────────────────────────────────────────────────────
        // CATATAN: route statis (gerbang, mapel) harus di atas wildcard.
        Route::prefix('barcode')->name('barcode.')->group(function () {
            Route::get('/',        [SiswaBarcodeController::class, 'index'])->name('index');
            Route::get('gerbang',  [SiswaBarcodeController::class, 'gerbang'])->name('gerbang');
            Route::get('mapel',    [SiswaBarcodeController::class, 'mapel'])->name('mapel');
        });

        // ── Jadwal ─────────────────────────────────────────────────────────
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/',        [SiswaJadwalController::class, 'index'])->name('index');
            Route::get('{jadwal}', [SiswaJadwalController::class, 'show'])->name('show');
        });

        // ── Jadwal ──────────────────────────────────────────────────────────────────
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/',        [SiswaJadwalController::class, 'index'])->name('index');
            Route::get('{jadwal}', [SiswaJadwalController::class, 'show'])->name('show');
        });

        // ── Materi ─────────────────────────────────────────────────────────
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/',        [SiswaMateriController::class, 'index'])->name('index');
            Route::get('{materi}', [SiswaMateriController::class, 'show'])->name('show');
        });

        // ── Nilai ──────────────────────────────────────────────────────────
        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/',     [SiswaNilaiController::class, 'index'])->name('index');
            Route::get('rapor', [SiswaNilaiController::class, 'rapor'])->name('rapor');
        });

        // ── Tugas ──────────────────────────────────────────────────────────
        Route::prefix('tugas')->name('tugas.')->group(function () {
            Route::get('/',               [SiswaTugasController::class, 'index'])->name('index');
            Route::get('{tugas}',         [SiswaTugasController::class, 'show'])->name('show');
            Route::post('{tugas}/kumpul', [SiswaTugasController::class, 'kumpul'])->name('kumpul');
        });

        // ── Ujian ──────────────────────────────────────────────────────────
        Route::prefix('ujian')->name('ujian.')->group(function () {
            Route::get('/',                          [SiswaUjianController::class, 'index'])->name('index');
            Route::get('riwayat',                    [SiswaUjianController::class, 'riwayat'])->name('riwayat');
            Route::get('{ujian}/info',               [SiswaUjianController::class, 'info'])->name('info');
            Route::post('{ujian}/start',             [SiswaUjianController::class, 'start'])->name('start');
            Route::get('{ujian}/kerjakan',           [SiswaUjianController::class, 'kerjakan'])->name('kerjakan');
            Route::post('{ujian}/soal/{soal}/jawab', [SiswaUjianController::class, 'jawab'])->name('jawab');
            Route::post('{ujian}/selesai',           [SiswaUjianController::class, 'selesai'])->name('selesai');
            Route::get('{ujian}/hasil',              [SiswaUjianController::class, 'hasil'])->name('hasil');
        });

        // ── Notifikasi ─────────────────────────────────────────────────────
        // CATATAN: 'read-all' harus di atas '{notifikasi}' agar tidak tertangkap wildcard
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/',                   [SiswaNotifikasiController::class, 'index'])->name('index');
            Route::patch('read-all',          [SiswaNotifikasiController::class, 'markAllRead'])->name('read-all');
            Route::get('{notifikasi}',        [SiswaNotifikasiController::class, 'show'])->name('show');
            Route::patch('{notifikasi}/read', [SiswaNotifikasiController::class, 'markRead'])->name('read');
            Route::delete('{notifikasi}',     [SiswaNotifikasiController::class, 'destroy'])->name('destroy');
        });

        // ── Pelanggaran ────────────────────────────────────────────────────
        Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
            Route::get('/',              [SiswaPelanggaranController::class, 'index'])->name('index');
            Route::get('{pelanggaran}', [SiswaPelanggaranController::class, 'show'])->name('show');
        });

        // ── Pengumuman ─────────────────────────────────────────────────────
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/',            [SiswaPengumumanController::class, 'index'])->name('index');
            Route::get('{pengumuman}', [SiswaPengumumanController::class, 'show'])->name('show');
        });

    }); // end siswa

    // ══════════════════════════════════════════════════════════════════════
    // ORANG TUA
    // ══════════════════════════════════════════════════════════════════════
    Route::prefix('ortu')->middleware('role:orang_tua')->name('api.ortu.')->group(function () {

        Route::get('dashboard', [OrangTuaDashboardController::class, 'index'])->name('dashboard');

        Route::get('anak',           [ProfilAnakController::class, 'index'])->name('anak.index');
        Route::get('anak/{siswaId}', [ProfilAnakController::class, 'show'])->name('anak.show');

        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('hari-ini', [OrangTuaAbsensiController::class, 'statusHariIni'])->name('hari-ini');
            Route::get('riwayat',  [OrangTuaAbsensiController::class, 'riwayat'])->name('riwayat');
            Route::get('rekap',    [OrangTuaAbsensiController::class, 'rekap'])->name('rekap');
        });

        Route::prefix('kehadiran-gerbang')->name('kehadiran-gerbang.')->group(function () {
            Route::get('status-hari-ini', [OrangTuaKehadiranGerbangController::class, 'statusHariIni'])->name('status-hari-ini');
            Route::get('riwayat',         [OrangTuaKehadiranGerbangController::class, 'riwayat'])->name('riwayat');
            Route::get('rekap',           [OrangTuaKehadiranGerbangController::class, 'rekap'])->name('rekap');
        });

        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('nilai', [OrangTuaAkademikController::class, 'nilai'])->name('nilai');
            Route::get('rapor', [OrangTuaAkademikController::class, 'rapor'])->name('rapor');
            Route::get('tugas', [OrangTuaAkademikController::class, 'tugas'])->name('tugas');
        });

        Route::get('kedisiplinan/riwayat', [KedisiplinanController::class, 'riwayat'])->name('kedisiplinan.riwayat');

        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/',                   [OrangTuaNotifikasiController::class, 'index'])->name('index');
            Route::patch('read-all',          [OrangTuaNotifikasiController::class, 'markAllRead'])->name('read-all');
            Route::get('{notifikasi}',        [OrangTuaNotifikasiController::class, 'show'])->name('show');
            Route::patch('{notifikasi}/read', [OrangTuaNotifikasiController::class, 'markRead'])->name('read');
            Route::delete('{notifikasi}',     [OrangTuaNotifikasiController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/',            [OrangTuaPengumumanController::class, 'index'])->name('index');
            Route::get('{pengumuman}', [OrangTuaPengumumanController::class, 'show'])->name('show');
        });

    }); // end ortu

}); // end auth:sanctum