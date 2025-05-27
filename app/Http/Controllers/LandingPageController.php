<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
public function index()
{
$pages = LandingPage::where('user_id', auth()->id())->get();
$total = $pages->count();
$limit = auth()->user()->max_pages ?? 1;
return view('landing.index', compact('pages', 'total', 'limit'));
}

public function store(Request $request)
{
    $request->validate([
        'slug' => 'required|alpha_dash|unique:landing_pages,slug',
        'judul' => 'required|string|max:255',
    ]);

    $count = LandingPage::where('user_id', auth()->id())->count();
    $limit = auth()->user()->max_pages ?? 1;

    if ($count >= $limit) {
        return back()->with('error', 'Maksimal jumlah landing page telah tercapai.');
    }

    LandingPage::create([
        'user_id' => auth()->id(),
        'slug' => $request->slug,
        'judul' => $request->judul
    ]);

    return back()->with('success', 'Landing page berhasil dibuat!');
}
}