<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $in90days = Carbon::today()->addDays(90);

        // List UMKM yang menjelang expired (3 bulan ke depan)
        $umkmExpSoon = User::where('role', 'umkm')
            ->where('status_aktif', true)
            ->whereNotNull('aktif_sampai')
            ->whereDate('aktif_sampai', '>=', $today)
            ->whereDate('aktif_sampai', '<=', $in90days)
            ->get();

        // Total UMKM aktif
        $totalUmkm = User::where('role', 'umkm')->count();

        // Total UMKM menjelang expired (3 bulan ke depan)
        $totalUmkmExpSoon = $umkmExpSoon->count();

        // Total UMKM expired
        $totalUmkmExpired = User::where('role', 'umkm')
            ->whereNotNull('aktif_sampai')
            ->where('aktif_sampai', '<', Carbon::now())
            ->count();

        // Total UMKM menunggu aktivasi
        $totalUmkmPending = User::where('role', 'umkm')
            ->where(function($q){
                $q->where('status_aktif', false)
                  ->orWhereNull('status_aktif');
            })
            ->count();

        return view('dashboard', compact(
            'umkmExpSoon',
            'totalUmkm',
            'totalUmkmExpSoon',
            'totalUmkmExpired',
            'totalUmkmPending'
        ));
    }
}