<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekStatusAktif
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('CekStatusAktif middleware dijalankan');
        if (auth()->check() && auth()->user()->status_aktif == false) {
            auth()->logout();
            return redirect('/login')->withErrors([
                'email' => 'Akun kamu belum diaktivasi. Hubungi admin.'
            ]);
        }
        return $next($request);
    }
}