<?php

use App\Http\Controllers\Api\Siswa\AbsensiController;
use App\Http\Controllers\Api\Siswa\DashboardController;
use App\Http\Controllers\Api\Siswa\JadwalController;
use App\Http\Controllers\Api\Siswa\MateriController;
use App\Http\Controllers\Api\Siswa\NilaiController;
use App\Http\Controllers\Api\Siswa\NotifikasiController;
use App\Http\Controllers\Api\Siswa\PelanggaranController;
use App\Http\Controllers\Api\Siswa\PengumumanController;
use App\Http\Controllers\Api\Siswa\TugasController;
use App\Http\Controllers\Api\Siswa\UjianController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Siswa
|--------------------------------------------------------------------------
| Prefix  : /api/siswa
| Middleware: auth:sanctum, role:siswa   (sesuaikan dengan guard yang dipakai)
|
| Tambahkan ke routes/api.php:
|
|   Route::prefix('siswa')
|       ->middleware(['auth:sanctum', 'role:siswa'])
|       ->name('api.siswa.')
|       ->group(base_path('routes/api_siswa.php'));
|
*/

// ── Dashboard ────────────────────────────────────────────────────────────────
// GET /api/siswa/dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ── Absensi ──────────────────────────────────────────────────────────────────
Route::prefix('absensi')->name('absensi.')->group(function () {
    // GET  /api/siswa/absensi/status-hari-ini
    Route::get('status-hari-ini', [AbsensiController::class, 'statusHariIni'])->name('status-hari-ini');

    // POST /api/siswa/absensi/scan
    Route::post('scan', [AbsensiController::class, 'prosesQr'])->name('scan');

    // GET  /api/siswa/absensi/riwayat   ?status=&tanggal_dari=&tanggal_sampai=&bulan=&tahun=&per_page=
    Route::get('riwayat', [AbsensiController::class, 'riwayat'])->name('riwayat');
});

// ── Jadwal ───────────────────────────────────────────────────────────────────
Route::prefix('jadwal')->name('jadwal.')->group(function () {
    // GET  /api/siswa/jadwal            ?hari=senin|selasa|...
    Route::get('/', [JadwalController::class, 'index'])->name('index');

    // GET  /api/siswa/jadwal/{jadwal}
    Route::get('{jadwal}', [JadwalController::class, 'show'])->name('show');
});

// ── Materi ───────────────────────────────────────────────────────────────────
Route::prefix('materi')->name('materi.')->group(function () {
    // GET  /api/siswa/materi            ?mapel_id=&jenis=&cari=&per_page=
    Route::get('/', [MateriController::class, 'index'])->name('index');

    // GET  /api/siswa/materi/{materi}
    Route::get('{materi}', [MateriController::class, 'show'])->name('show');
});

// ── Nilai ────────────────────────────────────────────────────────────────────
Route::prefix('nilai')->name('nilai.')->group(function () {
    // GET  /api/siswa/nilai             ?tahun_ajaran_id=&mapel_id=
    Route::get('/', [NilaiController::class, 'index'])->name('index');

    // GET  /api/siswa/nilai/rapor       ?tahun_ajaran_id=
    Route::get('rapor', [NilaiController::class, 'rapor'])->name('rapor');
});

// ── Tugas ────────────────────────────────────────────────────────────────────
Route::prefix('tugas')->name('tugas.')->group(function () {
    // GET  /api/siswa/tugas             ?status=sudah|belum|terlambat&mapel_id=&per_page=
    Route::get('/', [TugasController::class, 'index'])->name('index');

    // GET  /api/siswa/tugas/{tugas}
    Route::get('{tugas}', [TugasController::class, 'show'])->name('show');

    // POST /api/siswa/tugas/{tugas}/kumpul   (multipart/form-data)
    Route::post('{tugas}/kumpul', [TugasController::class, 'kumpul'])->name('kumpul');
});

// ── Ujian ────────────────────────────────────────────────────────────────────
Route::prefix('ujian')->name('ujian.')->group(function () {
    // GET  /api/siswa/ujian
    Route::get('/', [UjianController::class, 'index'])->name('index');

    // GET  /api/siswa/ujian/riwayat
    Route::get('riwayat', [UjianController::class, 'riwayat'])->name('riwayat');

    // GET  /api/siswa/ujian/{ujian}/info
    Route::get('{ujian}/info', [UjianController::class, 'info'])->name('info');

    // POST /api/siswa/ujian/{ujian}/start
    Route::post('{ujian}/start', [UjianController::class, 'start'])->name('start');

    // GET  /api/siswa/ujian/{ujian}/kerjakan
    Route::get('{ujian}/kerjakan', [UjianController::class, 'kerjakan'])->name('kerjakan');

    // POST /api/siswa/ujian/{ujian}/soal/{soal}/jawab
    Route::post('{ujian}/soal/{soal}/jawab', [UjianController::class, 'jawab'])->name('jawab');

    // POST /api/siswa/ujian/{ujian}/selesai
    Route::post('{ujian}/selesai', [UjianController::class, 'selesai'])->name('selesai');

    // GET  /api/siswa/ujian/{ujian}/hasil
    Route::get('{ujian}/hasil', [UjianController::class, 'hasil'])->name('hasil');
});

// ── Notifikasi ───────────────────────────────────────────────────────────────
Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
    // GET  /api/siswa/notifikasi        ?status=belum_dibaca|dibaca&per_page=
    Route::get('/', [NotifikasiController::class, 'index'])->name('index');

    // PATCH /api/siswa/notifikasi/read-all
    Route::patch('read-all', [NotifikasiController::class, 'markAllRead'])->name('read-all');

    // GET    /api/siswa/notifikasi/{notifikasi}
    Route::get('{notifikasi}', [NotifikasiController::class, 'show'])->name('show');

    // PATCH  /api/siswa/notifikasi/{notifikasi}/read
    Route::patch('{notifikasi}/read', [NotifikasiController::class, 'markRead'])->name('read');

    // DELETE /api/siswa/notifikasi/{notifikasi}
    Route::delete('{notifikasi}', [NotifikasiController::class, 'destroy'])->name('destroy');
});

// ── Pelanggaran ──────────────────────────────────────────────────────────────
Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
    // GET  /api/siswa/pelanggaran       ?kategori_id=&status=&tanggal_dari=&tanggal_sampai=&per_page=
    Route::get('/', [PelanggaranController::class, 'index'])->name('index');

    // GET  /api/siswa/pelanggaran/{pelanggaran}
    Route::get('{pelanggaran}', [PelanggaranController::class, 'show'])->name('show');
});

// ── Pengumuman ───────────────────────────────────────────────────────────────
Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
    // GET  /api/siswa/pengumuman        ?cari=&per_page=
    Route::get('/', [PengumumanController::class, 'index'])->name('index');

    // GET  /api/siswa/pengumuman/{pengumuman}
    Route::get('{pengumuman}', [PengumumanController::class, 'show'])->name('show');
});