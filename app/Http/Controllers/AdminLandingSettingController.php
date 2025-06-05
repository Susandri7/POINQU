<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminLandingSettingController extends Controller
{
    // Tampilkan semua UMKM dan limit landing pagenya
    public function index() {
        $users = User::where('role', 'umkm')->get();
        return view('admin.landing_settings', compact('users'));
    }

    // Tambah limit landing page per user
    public function updateMaxPages(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = User::findOrFail($id);
        $user->max_pages = ($user->max_pages ?? 0) + $request->jumlah;
        $user->save();

        return redirect()->back()->with('success', 'Limit Landing Page berhasil ditambah!');
    }
}