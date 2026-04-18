<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

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