<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
public function index(Request $request)
{
$cari = $request->input('cari');
$members = Member::where('user_id', Auth::id())
->when($cari, function ($query, $cari) {
$query->where('nama', 'like', "%$cari%")
->orWhere('wa', 'like', "%$cari%");
})
->orderBy('waktu_pendaftaran', 'desc')
->paginate(15);

$totalMember = $members->total();
$totalPoin = Member::where('user_id', Auth::id())->sum('poin');

return view('member.index', compact('members', 'cari', 'totalMember', 'totalPoin'));
}

public function tambahPoin(Request $request, $id)
{
$member = Member::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
$jumlah = $request->input('jumlah', 1);

$member->poin += $jumlah;
$member->save();

return back()->with('success', "Berhasil menambahkan $jumlah poin ke {$member->nama}.");
}

public function tukarPoin(Request $request, $id)
{
$member = Member::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
$jumlah = $request->input('jumlah', 10); // misal 10 poin = 1 hadiah

if ($member->poin < $jumlah) {
    return back()->with('error', 'Poin tidak cukup.');
}

$member->poin -= $jumlah;
$member->poin_ditukar += $jumlah;
$member->save();

return back()->with('success', "{$member->nama} berhasil menukar {$jumlah} poin.");
}
}