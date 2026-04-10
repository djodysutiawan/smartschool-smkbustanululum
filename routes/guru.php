<?php

use Illuminate\Support\Facades\Route;

Route::prefix('guru')
    ->middleware(['auth', 'role:guru'])
    ->group(function () {

        Route::get('/dashboard', fn() => view('guru.dashboard'));
    });