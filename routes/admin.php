<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });

        Route::get('/users', fn() => view('admin.users'));
    });