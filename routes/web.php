<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberFormController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\AktivasiController;
use App\Models\LandingPage;
use App\Models\User;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;




// Halaman awal
Route::get('/', function () {
    return view('home');
});

// Halaman dashboard setelah login & verifikasi email
Route::get('/dashboard', function () {
    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
})->middleware(['auth', 'verified', 'cek-masa-aktif'])->name('dashboard');

// ------------------------
// FORM PENDAFTARAN UMUM (Publik)
Route::get('/daftar', [MemberFormController::class, 'showForm'])->name('form.daftar');
Route::post('/daftar', [MemberFormController::class, 'submitForm'])->name('form.submit');

// ------------------------
Route::middleware(['auth', 'aktif'])->group(function () {
    Route::get('/landing', [LandingPageController::class, 'index'])->name('landing.index');
    Route::post('/landing', [LandingPageController::class, 'store'])->name('landing.store');
});

// ------------------------

Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');

// ------------------------
Route::middleware(['auth', 'aktif'])->group(function () {
    Route::get('/member', [MemberDashboardController::class, 'index'])->name('member.index');
    Route::post('/member/tambah-poin/{id}', [MemberDashboardController::class, 'tambahPoin'])->name('member.tambah-poin');
    Route::post('/member/tukar-poin/{id}', [MemberDashboardController::class, 'tukarPoin'])->name('member.tukar-poin');
});

// FORM PREVIEW (untuk admin/umkm melihat tampilan publik)
Route::get('/form-pendaftaran', [MemberFormController::class, 'showForm'])
    ->middleware(['auth', 'aktif'])
    ->name('form.pendaftaran');

Route::get('/form-preview', function () {
    return view('form-pendaftaran');
})->middleware(['auth'])->name('form.preview');

// ------------------------
// INPUT KODE (fitur tambah poin dan tukar poin)
Route::middleware(['auth', 'aktif'])->group(function () {
    Route::get('/input-kode', function () {
        return view('input-kode');
    })->name('input-kode');
});

// ------------------------
Route::middleware(['auth', 'aktif'])->group(function () {
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [SettingController::class, 'update'])->name('pengaturan.update');
    });
// ------------------------
Route::get('/landing/{id}/edit', [App\Http\Controllers\LandingPageController::class, 'edit'])->name('landing.edit');
Route::put('/landing/{id}', [App\Http\Controllers\LandingPageController::class, 'update'])->name('landing.update');

//Route::get('/landing/{id}/edit', [LandingPageController::class, 'edit'])->name('landing.edit');
//Route::put('/landing/{id}', [LandingPageController::class, 'update'])->name('landing.update');
Route::delete('/landing/{id}', [LandingPageController::class, 'destroy'])->name('landing.destroy');
// ------------------------

Route::middleware(['auth'])->get('/aktivasi', [AktivasiController::class, 'index'])->name('aktivasi');
Route::middleware(['auth'])->post('/aktivasi/{id}', [AktivasiController::class, 'proses'])->name('aktivasi.proses');

// ----------Backup Download Dari dashboar Admin------

Route::get('/admin/download-backup', function () {
    $files = collect(Storage::disk('private')->files('laravel'))->sortDesc();
    $latest = $files->first();
    if (!$latest) {
        if (request()->expectsJson()) {
            return response()->json(['error' => 'File backup tidak ditemukan'], 404);
        }
        return back()->with('error', 'Belum ada file backup yang tersedia.');
    }
    return Storage::disk('private')->download($latest);
})->middleware('auth')->name('backup.download');

//ini yang berhasil
//Route::get('/admin/download-backup', function () {
    //$files = collect(Storage::disk('private')->files('laravel'))->sortDesc();
    //$latest = $files->first();
    //if (!$latest) {
        //return back()->with('error', 'Belum ada file backup yang tersedia.');
    //}
    
    //return Storage::disk('private')->download($latest);
//})->middleware('auth')->name('backup.download');

//berhasil



// ------------------------
// FITUR PROFIL DEFAULT BREEZE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//----------------------------
//Route::get('/{slug}', [LandingPageController::class, 'show'])->name('landing.show');
// ------------------------
// ⛔ Wildcard slug HARUS PALING BAWAH!
Route::get('/{slug}', function ($slug) {
    $landing = LandingPage::where('slug', $slug)->firstOrFail();
    $user_id = $landing->user_id;
    return view('form-dinamis', [
        'landing' => $landing,
        'user_id' => $user_id
    ]);
})->name('form.slug');