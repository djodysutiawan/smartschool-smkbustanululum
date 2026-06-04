<?php

namespace App\Providers;

use App\Models\Guru;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use App\Observers\GuruObserver;
use App\Observers\OrangTuaObserver;
use App\Observers\SiswaObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Guru::observe(GuruObserver::class);
        Siswa::observe(SiswaObserver::class);use Illuminate\Auth\Notifications\ResetPassword; // ← tambah
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        User::observe(UserObserver::class);
        Guru::observe(GuruObserver::class);
        Siswa::observe(SiswaObserver::class);
        OrangTua::observe(OrangTuaObserver::class);

        // ← tambah
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('app.frontend_url') . '/reset-password?token=' . $token . '&email=' . urlencode($user->email);
        });
    }
}
        OrangTua::observe(OrangTuaObserver::class);
    }
}