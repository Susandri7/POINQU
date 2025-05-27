<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Member;

class MemberFormController extends Controller
{
    public function showForm()
    {
        return view('form-pendaftaran');
    }

    public function submitForm(Request $request)
    {
        // Cek apakah WA sudah pernah didaftarkan
        $existing = Member::where('wa', $request->wa)->first();
        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'wa' => 'Nomor WA sudah terdaftar atas nama: ' . $existing->nama . ' dengan kode unik: ' . $existing->kode_unik,
                ]);
        }

        // Validasi data (tambah validasi user_id opsional)
        $request->validate([
            'nama' => 'required|string|max:100',
            'wa' => 'required|string|max:20',
            'desa' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // --- Generate kode unik 2 huruf 4 angka dan pastikan belum ada di DB
        

            $kode = '';
            do {
            $kode = strtoupper(Str::random(2)) . rand(1000, 9999);
            } while (Member::where('kode_unik', $kode)->exists());
            
         

        $member = Member::create([
            'user_id' => $request->user_id ?? auth()->id() ?? 1, // fallback ke user login, jika tidak ada pakai 1
            'kode_unik' => $kode,
            'nama' => ucwords(strtolower(trim($request->nama))),
            'wa' => $request->wa,
            'desa' => ucwords(strtolower(trim($request->desa))),
            'tanggal_lahir' => $request->tanggal_lahir,
            'waktu_pendaftaran' => now(),
        ]);

        return back()->with('success', 'Selamat! Kode Member kamu adalah: ' . $kode);
    }
}