<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil semua user selain admin yang akan expired ≤ 90 hari ke depan, cek hanya TANGGAL (bukan jam) agar aman timezone dan pasti terjaring
        $today = Carbon::today();
        $in90days = Carbon::today()->addDays(90);

        $umkmExpSoon = User::where('email', '!=', 'admin@poinqu.my.id')
            ->where('status_aktif', true)
            ->whereNotNull('aktif_sampai')
            ->whereDate('aktif_sampai', '>=', $today)
            ->whereDate('aktif_sampai', '<=', $in90days)
            ->get();

        // Data dashboard lain ...

        return view('dashboard', compact('umkmExpSoon'));
    }
}