<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PointApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/cek-kode/{kode}', [PointApiController::class, 'cekKode']);
Route::post('/tambah-poin', [PointApiController::class, 'tambahPoin']);
Route::post('/tukar-poin', [PointApiController::class, 'tukarPoin']);