<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekMasaAktifUser
{
    public function handle($request, Closure $next)
    {
        \Log::info('CekMasaAktifUser DIJALANKAN', [
            'user' => Auth::user()?->email,
            'status_aktif' => Auth::user()?->status_aktif,
            'aktif_sampai' => Auth::user()?->aktif_sampai,
            'now' => now()->toDateTimeString(),
        ]);
        $user = Auth::user();
        if (
            $user &&
            $user->role === 'umkm' && // Ganti dari email ke role
            $user->status_aktif &&
            $user->aktif_sampai &&
            now()->greaterThan($user->aktif_sampai)
        ) {
            \Log::info('Masa aktif sudah lewat, akan di-nonaktifkan', [
                'user' => $user->email,
                'aktif_sampai' => $user->aktif_sampai,
                'now' => now()->toDateTimeString(),
            ]);
            $user->status_aktif = false;
            $user->save();
            Auth::setUser($user);
        }
        return $next($request);
    }
}