<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Setting;

class PoinController extends Controller
{
    public function cekKode($kode)
    {
        $member = Member::where('kode_unik', $kode)->first();

        if (!$member) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'member' => [
                'nama' => $member->nama,
                'poin' => $member->poin,
                'kode_unik' => $member->kode_unik,
                'wa' => $member->wa
            ]
        ]);
    }

    public function tambah(Request $request)
    {
        $kode = $request->input('kode');
        $poin = $request->input('poin', 1);

        $member = Member::where('kode_unik', $kode)->first();

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member tidak ditemukan']);
        }

        $member->poin += $poin;
        $member->save();

        $link = 'https://wa.me/' . preg_replace('/^0/', '62', $member->wa) . '?text=' . urlencode("Halo *{$member->nama}*, poin kamu sudah ditambahkan yaa~ 🪙 Poin sekarang: {$member->poin}");

        return response()->json([
            'success' => true,
            'message' => 'Poin berhasil ditambahkan',
            'poin' => $member->poin,
            'link_wa' => $link
        ]);
    }

    public function tukar(Request $request)
    {
        $kode = $request->input('kode');
        $hadiah_id = $request->input('hadiah_id');

        $member = Member::where('kode_unik', $kode)->first();

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member tidak ditemukan']);
        }

        $nama_hadiah = Setting::where('user_id', $member->user_id)
            ->where('parameter', 'Hadiah ' . $hadiah_id)->value('nilai');

        $harga_poin = Setting::where('user_id', $member->user_id)
            ->where('parameter', 'Harga Poin Hadiah ' . $hadiah_id)->value('nilai');

        if (!$nama_hadiah || !$harga_poin) {
            return response()->json(['success' => false, 'message' => 'Hadiah tidak ditemukan']);
        }

        if ($member->poin < $harga_poin) {
            return response()->json(['success' => false, 'message' => 'Poin tidak cukup']);
        }

        $poinSebelumnya = $member->poin;
        $member->poin -= $harga_poin;
        $member->save();

        $template = Setting::where('user_id', $member->user_id)
            ->where('parameter', 'Pesan Notif Tukar Poin')->value('nilai');

        $template = str_replace([
            '{nama}', '{hadiah}', '{hari}', '{tanggal}', '{jam}',
            '{poinSebelumnya}', '{poinDitukar}', '{poinSisa}'
        ], [
            $member->nama,
            $nama_hadiah,
            now()->format('l'),
            now()->format('d M Y'),
            now()->format('H:i'),
            $poinSebelumnya,
            $harga_poin,
            $member->poin
        ], $template);

        $wa = preg_replace('/^0/', '62', $member->wa);
        $link = 'https://wa.me/' . $wa . '?text=' . urlencode($template);

        return response()->json([
            'success' => true,
            'message' => 'Poin berhasil ditukar',
            'link_wa' => $link
        ]);
    }
}