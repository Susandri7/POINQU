<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UmkmController extends Controller
{
    public function index() {
        $users = User::where('role', 'umkm')->get();
        return view('umkm.index', compact('users'));
    }

    public function expiring() {
        $users = User::where('role', 'umkm')
            ->whereNotNull('aktif_sampai')
            ->where('aktif_sampai', '>', Carbon::now())
            ->where('aktif_sampai', '<=', Carbon::now()->addMonths(3))
            ->get();
        return view('umkm.expiring', compact('users'));
    }

    public function expired() {
        $users = User::where('role', 'umkm')
            ->whereNotNull('aktif_sampai')
            ->where('aktif_sampai', '<', Carbon::now())
            ->get();
        return view('umkm.expired', compact('users'));
    }

    public function pending() {
        $users = User::where('role', 'umkm')
            ->where(function($q){
                $q->where('status_aktif', false)
                  ->orWhereNull('status_aktif');
            })
            ->get();
        return view('umkm.pending', compact('users'));
    }
}