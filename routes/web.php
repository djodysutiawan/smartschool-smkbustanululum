<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'admin' => redirect('/admin/dashboard'),
        'guru' => redirect('/guru/dashboard'),
        'siswa' => redirect('/siswa/dashboard'),
        'orang_tua' => redirect('/orangtua/dashboard'),
        'guru_piket' => redirect('/piket/dashboard'),
        default => abort(403),
    };
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';