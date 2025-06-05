<?php

namespace App\Providers;

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
        //
    }

    public static function redirectTo()
    {
        if (auth()->user()->role === 'admin') { // Ganti dari email ke role
            return '/dashboard'; // Bisa /admin/dashboard
        } else {
            return '/dashboard'; // UMKM biasa
        }
    }
}