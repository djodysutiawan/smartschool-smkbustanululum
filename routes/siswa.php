<?php 

use Illuminate\Support\Facades\Route;

Route::prefix('siswa')
    ->middleware(['auth', 'role:siswa'])
    ->group(function () {

        Route::get('/dashboard', fn() => view('siswa.dashboard'));
    });