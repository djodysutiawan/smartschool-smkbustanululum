<?php

use Illuminate\Support\Facades\Route;

Route::prefix('orangtua')
    ->middleware(['auth', 'role:orang_tua'])
    ->group(function () {

        Route::get('/dashboard', fn() => view('orangtua.dashboard'));
    });