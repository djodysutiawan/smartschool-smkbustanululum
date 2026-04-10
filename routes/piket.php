<?php

use Illuminate\Support\Facades\Route;

Route::prefix('piket')
    ->middleware(['auth', 'role:guru_piket'])
    ->group(function () {

        Route::get('/dashboard', fn() => view('piket.dashboard'));
    });