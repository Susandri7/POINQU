<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // ✅ ini harus ADA
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Ini adalah tempat yang tepat untuk mendaftarkan middleware.
        $middleware->alias([
            'aktif' => \App\Http\Middleware\CekStatusAktif::class,
            'cek-masa-aktif' => \App\Http\Middleware\CekMasaAktifUser::class,
       
        ]);

      


        // Tambahkan ini agar CekMasaAktifUser berjalan GLOBAL di semua request
        //$middleware->append(\App\Http\Middleware\CekMasaAktifUser::class);
    })

    // ---------- Back Up Otomatis ----------
    ->withSchedule(function (Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('backup:run')->dailyAt('03:00');
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();