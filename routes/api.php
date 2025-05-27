<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PoinController;

Route::get('/cek-kode/{kode}', [PoinController::class, 'cekKode']);
Route::post('/tambah-poin', [PoinController::class, 'tambah']);
Route::post('/tukar-poin', [PoinController::class, 'tukar']);