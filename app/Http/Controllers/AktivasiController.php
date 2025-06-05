<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AktivasiController extends Controller
{
    // Halaman daftar user untuk aktivasi
    public function index()
    {
        if (Auth::user()->email !== 'admin@poinqu.my.id') {
            abort(403, 'Kamu bukan admin.');
        }
        // Ambil semua user (bisa filter sesuai kebutuhan)
        $users = User::all();
        return view('aktivasi', compact('users'));
    }

    // Proses aktivasi/nonaktifkan user
    public function proses(Request $request, $id)
    {
        if (Auth::user()->email !== 'admin@poinqu.my.id') {
            abort(403, 'Kamu bukan admin.');
        }
        $user = User::findOrFail($id);

        if ($user->email === 'admin@poinqu.my.id') {
            return back()->with('success', 'Akun admin tidak boleh diubah statusnya.');
        }
        
        $aksi = $request->input('aksi', 'aktifkan');

        if ($aksi === 'nonaktifkan') {
            $user->status_aktif = false;
            $user->aktif_mulai = null;
            $user->aktif_sampai = null;
            $pesan = 'User berhasil dinonaktifkan!';
        } else {
            $user->status_aktif = true;

            // Cek ada input masa aktif dari admin
            $durasi = (int) $request->input('durasi', 1);
            $satuan = $request->input('satuan', 'hari');
            $mulai = Carbon::now();
            // Hitung masa aktif
            switch ($satuan) {
                case 'menit':
                    $sampai = $mulai->copy()->addMinutes($durasi);
                    break;
                case 'jam':
                    $sampai = $mulai->copy()->addHours($durasi);
                    break;
                case 'hari':
                    $sampai = $mulai->copy()->addDays($durasi);
                    break;
                case 'bulan':
                    $sampai = $mulai->copy()->addMonths($durasi);
                    break;
                case 'tahun':
                    $sampai = $mulai->copy()->addYears($durasi);
                    break;
                default:
                    $sampai = $mulai->copy()->addDays($durasi);
            }
            $user->aktif_mulai = $mulai;
            $user->aktif_sampai = $sampai;

            $pesan = "User berhasil diaktifkan selama $durasi $satuan!";
        }
        $user->save();
        return back()->with('success', $pesan);
    }

    // Proses perpanjangan masa aktif user
    public function perpanjang(Request $request, $id)
    {
        if (Auth::user()->email !== 'admin@poinqu.my.id') {
            abort(403, 'Kamu bukan admin.');
        }

        $user = User::findOrFail($id);

        // Ambil input durasi dan satuan
        $durasi = (int) $request->input('durasi', 1);
        $satuan = $request->input('satuan', 'hari');

        // Penentuan waktu mulai penambahan: 
        // - Jika masa aktif masih berlaku, perpanjang dari aktif_sampai
        // - Jika sudah lewat (expired), perpanjang dari sekarang
        $start = Carbon::now();
        if ($user->aktif_sampai && Carbon::parse($user->aktif_sampai)->gt($start)) {
            $start = Carbon::parse($user->aktif_sampai);
        }

        // Hitung tanggal baru setelah perpanjangan
        switch ($satuan) {
            case 'menit':
                $akhir = $start->copy()->addMinutes($durasi);
                break;
            case 'jam':
                $akhir = $start->copy()->addHours($durasi);
                break;
            case 'hari':
                $akhir = $start->copy()->addDays($durasi);
                break;
            case 'bulan':
                $akhir = $start->copy()->addMonths($durasi);
                break;
            case 'tahun':
                $akhir = $start->copy()->addYears($durasi);
                break;
            default:
                $akhir = $start->copy()->addDays($durasi);
        }

        // Set aktif_mulai jika user expired, jika tidak biarkan
        if (!$user->aktif_mulai || Carbon::parse($user->aktif_sampai)->lt(Carbon::now())) {
            $user->aktif_mulai = Carbon::now();
        }

        // Update masa aktif
        $user->aktif_sampai = $akhir;
        $user->status_aktif = true;
        $user->save();

        return redirect()->back()->with('success', 'Masa aktif berhasil diperpanjang!');
    }
}