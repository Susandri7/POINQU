<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class PointApiController extends Controller
{
    // GET /api/cek-kode/{kode}
    public function cekKode($kode) {
        $member = Member::where('kode_unik', $kode)->first();
        if (!$member) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true, 'member' => $member]);
    }

    // POST /api/tambah-poin
    public function tambahPoin(Request $request) {
        $member = Member::where('kode_unik', $request->kode)->first();
        if (!$member) return response()->json(['success' => false]);

        $member->poin += $request->poin;
        $member->save();

        $link_wa = "https://wa.me/" . preg_replace('/^0/', '62', $member->wa) . "?text=" . urlencode("Poin kamu sekarang: $member->poin");

        return response()->json([
            'success' => true,
            'message' => "Poin berhasil ditambahkan.",
            'poin' => $member->poin,
            'link_wa' => $link_wa
        ]);
    }

    // POST /api/tukar-poin
    public function tukarPoin(Request $request) {
        // Logika tukar hadiah disesuaikan nanti
        return response()->json([
            'success' => true,
            'message' => "Poin berhasil ditukar.",
            'link_wa' => "https://wa.me/62xxxx"
        ]);
    }
}
