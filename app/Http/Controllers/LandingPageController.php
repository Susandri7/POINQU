<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'judul' => $request->judul,
        ]);

        return back()->with('success', 'Landing page berhasil dibuat!');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $page = LandingPage::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Pastikan konten dan form_fields berupa array saat dilempar ke view
        $page->konten = is_string($page->konten) ? json_decode($page->konten, true) : ($page->konten ?? []);
        $page->form_fields = is_string($page->form_fields) ? json_decode($page->form_fields, true) : ($page->form_fields ?? []);

        return view('landing.edit', compact('page'));
    }

    // Proses update data
    public function update(Request $request, $id)
    {
        $page = LandingPage::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'slug' => 'required|alpha_dash|unique:landing_pages,slug,'.$page->id,
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
            // Untuk fitur baru, konten dan form_fields boleh array dan nullable
            'konten' => 'nullable|array',
            'form_fields' => 'nullable|array',
        ]);

        // Ganti gambar jika diupload baru
        if ($request->hasFile('gambar')) {
            if ($page->gambar && Storage::exists('public/'.$page->gambar)) {
                Storage::delete('public/'.$page->gambar);
            }
            $file = $request->file('gambar')->store('landing-pages', 'public');
            $page->gambar = $file;
        }

        $page->slug = $request->slug;
        $page->judul = $request->judul;
        // Simpan konten dan form_fields sebagai array (akan otomatis jadi JSON di DB)
        $page->konten = $request->has('konten') ? array_values($request->konten) : [];
        $page->form_fields = $request->has('form_fields') ? array_values($request->form_fields) : [];
        $page->save();

        return redirect()->route('landing.index')->with('success', 'Landing Page berhasil diupdate!');
    }

    // Hapus landing page
    public function destroy($id)
    {
        $page = LandingPage::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        if ($page->gambar && Storage::exists('public/'.$page->gambar)) {
            Storage::delete('public/'.$page->gambar);
        }
        $page->delete();
        return redirect()->route('landing.index')->with('success', 'Landing page berhasil dihapus.');
    }
}