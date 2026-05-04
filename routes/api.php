<?php

use App\Http\Controllers\Api\Auth\AuthController;

// ── Siswa ──────────────────────────────────────────────────────────────────
use App\Http\Controllers\Api\Siswa\AbsensiController       as SiswaAbsensiController;
use App\Http\Controllers\Api\Siswa\DashboardController     as SiswaDashboardController;
use App\Http\Controllers\Api\Siswa\JadwalController        as SiswaJadwalController;
use App\Http\Controllers\Api\Siswa\MateriController        as SiswaMateriController;
use App\Http\Controllers\Api\Siswa\NilaiController         as SiswaNilaiController;
use App\Http\Controllers\Api\Siswa\NotifikasiController    as SiswaNotifikasiController;
use App\Http\Controllers\Api\Siswa\PelanggaranController   as SiswaPelanggaranController;
use App\Http\Controllers\Api\Siswa\PengumumanController    as SiswaPengumumanController;
use App\Http\Controllers\Api\Siswa\TugasController         as SiswaTugasController;
use App\Http\Controllers\Api\Siswa\UjianController         as SiswaUjianController;

// ── Orang Tua ──────────────────────────────────────────────────────────────
use App\Http\Controllers\Api\OrangTua\AbsensiController    as OrangTuaAbsensiController;
use App\Http\Controllers\Api\OrangTua\AkademikController   as OrangTuaAkademikController;
use App\Http\Controllers\Api\OrangTua\DashboardController  as OrangTuaDashboardController;
use App\Http\Controllers\Api\OrangTua\KedisiplinanController;
use App\Http\Controllers\Api\OrangTua\NotifikasiController as OrangTuaNotifikasiController;
use App\Http\Controllers\Api\OrangTua\PengumumanController as OrangTuaPengumumanController;
use App\Http\Controllers\Api\OrangTua\ProfilAnakController;

// ── Guru ───────────────────────────────────────────────────────────────────
use App\Http\Controllers\Api\Guru\DashboardController      as GuruDashboardController;

// ── Guru Piket ─────────────────────────────────────────────────────────────
use App\Http\Controllers\Api\Piket\DashboardController     as PiketDashboardController;

// ── Admin ──────────────────────────────────────────────────────────────────
use App\Http\Controllers\Api\Admin\DashboardController     as AdminDashboardController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// routes/api.php
// Route::get('/file/{path}', function (string $path) {
//     $fullPath = storage_path('app/public/' . $path);

//     if (!file_exists($fullPath)) {
//         abort(404);
//     }

//     return response()->file($fullPath, [
//         'Access-Control-Allow-Origin' => '*',
//         'Access-Control-Allow-Methods' => 'GET',
//         'Access-Control-Allow-Headers' => '*',
//     ]);
// })->where('path', '.*');
Route::get('/file/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);
 
    if (!file_exists($fullPath)) {
        abort(404, 'File not found: ' . $path);
    }
 
    $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';
    $fileSize = filesize($fullPath);
    $contents = file_get_contents($fullPath);
 
    // Gunakan response() biasa dengan content string — lebih stabil
    // dibanding response()->file() di php artisan serve (single-threaded)
    return response($contents, 200, [
        'Content-Type'                => $mimeType,
        'Content-Length'              => $fileSize,
        'Cache-Control'               => 'public, max-age=86400',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods'=> 'GET, OPTIONS',
        'Access-Control-Allow-Headers'=> '*',
    ]);
})->where('path', '.*');

Route::get('/avatar/{filename}', function ($filename) {
    $path = 'avatars/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return response()->file(
        storage_path('app/public/' . $path),
        [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET',
            'Access-Control-Allow-Headers' => '*',
        ]
    );
});

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
    Route::post('avatar',     [AuthController::class, 'uploadAvatar'])->name('avatar'); // ← TAMBAHAN
    Route::post('logout',     [AuthController::class, 'logout'])->name('logout');
    Route::post('logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');
});

// ── Protected routes ───────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // ══════════════════════════════════════════════════════════════════════
    // SISWA
    // ══════════════════════════════════════════════════════════════════════
    Route::prefix('siswa')->middleware('role:siswa')->name('api.siswa.')->group(function () {

        Route::get('dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('status-hari-ini', [SiswaAbsensiController::class, 'statusHariIni'])->name('status-hari-ini');
            Route::post('scan',           [SiswaAbsensiController::class, 'prosesQr'])->name('scan');
            Route::get('riwayat',         [SiswaAbsensiController::class, 'riwayat'])->name('riwayat');
        });

        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/',        [SiswaJadwalController::class, 'index'])->name('index');
            Route::get('{jadwal}', [SiswaJadwalController::class, 'show'])->name('show');
        });

        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/',        [SiswaMateriController::class, 'index'])->name('index');
            Route::get('{materi}', [SiswaMateriController::class, 'show'])->name('show');
        });

        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/',     [SiswaNilaiController::class, 'index'])->name('index');
            Route::get('rapor', [SiswaNilaiController::class, 'rapor'])->name('rapor');
        });

        Route::prefix('tugas')->name('tugas.')->group(function () {
            Route::get('/',               [SiswaTugasController::class, 'index'])->name('index');
            Route::get('{tugas}',         [SiswaTugasController::class, 'show'])->name('show');
            Route::post('{tugas}/kumpul', [SiswaTugasController::class, 'kumpul'])->name('kumpul');
        });

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

        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/',                   [SiswaNotifikasiController::class, 'index'])->name('index');
            Route::patch('read-all',          [SiswaNotifikasiController::class, 'markAllRead'])->name('read-all');
            Route::get('{notifikasi}',        [SiswaNotifikasiController::class, 'show'])->name('show');
            Route::patch('{notifikasi}/read', [SiswaNotifikasiController::class, 'markRead'])->name('read');
            Route::delete('{notifikasi}',     [SiswaNotifikasiController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
            Route::get('/',              [SiswaPelanggaranController::class, 'index'])->name('index');
            Route::get('{pelanggaran}', [SiswaPelanggaranController::class, 'show'])->name('show');
        });

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

        Route::get('pengumuman',             [OrangTuaPengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('pengumuman/{pengumuman}', [OrangTuaPengumumanController::class, 'show'])->name('pengumuman.show');

    }); // end ortu

    // ══════════════════════════════════════════════════════════════════════
    // GURU
    // ══════════════════════════════════════════════════════════════════════
    Route::prefix('guru')->middleware('role:guru')->name('api.guru.')->group(function () {

        Route::get('dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    }); // end guru

    // ══════════════════════════════════════════════════════════════════════
    // GURU PIKET
    // ══════════════════════════════════════════════════════════════════════
    Route::prefix('piket')->middleware('role:guru_piket')->name('api.piket.')->group(function () {

        Route::get('dashboard', [PiketDashboardController::class, 'index'])->name('dashboard');

    }); // end piket

    // ══════════════════════════════════════════════════════════════════════
    // ADMIN
    // ══════════════════════════════════════════════════════════════════════
    Route::prefix('admin')->middleware('role:admin')->name('api.admin.')->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    }); // end admin

}); // end auth:sanctum