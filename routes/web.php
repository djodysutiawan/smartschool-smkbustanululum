<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JurusanPublikController;
use App\Http\Controllers\PrestasiPublikController;
use App\Http\Controllers\ElearningController;
use App\Http\Controllers\NilaiPublikController;
use App\Http\Controllers\AbsensiPublikController;
use App\Models\Jurusan;
use App\Models\ProfilSekolah;

// Halaman utama
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/kontak', [WelcomeController::class, 'kirimKontak'])->name('kontak.kirim');
 
// Halaman publik jurusan
Route::prefix('jurusan')->name('jurusan.')->group(function () {
    Route::get('/',          [JurusanPublikController::class, 'index'])->name('index');
    Route::get('/{slug}',    [JurusanPublikController::class, 'show'])->name('show');
});
Route::get('/prestasi', [PrestasiPublikController::class, 'index'])->name('prestasi.index');
Route::get('/elearning', [ElearningController::class, 'index'])->name('elearning');
Route::get('/nilai',  [NilaiPublikController::class, 'index'])->name('nilai');
Route::post('/nilai', [NilaiPublikController::class, 'cek'])->name('nilai.cek');
Route::get('/absensi',      [AbsensiPublikController::class, 'index'])->name('absensi.index');
Route::post('/absensi/cek', [AbsensiPublikController::class, 'cek'])->name('absensi.cek');

// ppdb 
Route::get('/ppdb', function () {
    $profil  = ProfilSekolah::instance();
    $jurusan = Jurusan::where('is_published', true)
                ->orderBy('urutan')
                ->get();

    return view('ppdb.index', compact('profil', 'jurusan')); // ← ubah ini
})->name('ppdb');

// Dashboard — redirect berdasarkan role
Route::get('/dashboard', function () {
    return match (Auth::user()->role) {
        'admin'      => redirect('/admin/dashboard'),
        'guru'       => redirect('/guru/dashboard'),
        'siswa'      => redirect('/siswa/dashboard'),
        'orang_tua'  => redirect('/ortu/dashboard'),
        'guru_piket' => redirect('/piket/dashboard'),
        default      => abort(403, 'Role tidak dikenali.'),
    };
})->middleware('auth')->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/guru.php';
require __DIR__ . '/siswa.php';
require __DIR__ . '/orangtua.php';
require __DIR__ . '/piket.php';