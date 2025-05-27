<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller; // ✅ Tambahkan ini!

class SettingController extends Controller
{
    public function index()
    {
        // Ambil semua setting milik user saat ini
        $settings = Setting::where('user_id', Auth::id())->pluck('nilai', 'parameter');
        return view('setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $user_id = Auth::id();

        // Ambil semua input dari array parameter[]
        $data = $request->input('parameter', []);

        foreach ($data as $parameter => $nilai) {
            // Lewati kolom tambahan jika kosong
            if ($parameter == 'NamaBaru' || $parameter == 'NilaiBaru') {
                continue;
            }

            Setting::updateOrCreate(
                ['user_id' => $user_id, 'parameter' => $parameter],
                ['nilai' => $nilai]
            );
        }

        // Tambah parameter baru (opsional)
        if (!empty($data['NamaBaru'] ?? '') && isset($data['NilaiBaru'])) {
            Setting::updateOrCreate(
                ['user_id' => $user_id, 'parameter' => $data['NamaBaru']],
                ['nilai' => $data['NilaiBaru']]
            );
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}