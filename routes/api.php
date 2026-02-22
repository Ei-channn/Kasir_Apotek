<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\kategoriController;
use App\Http\Controllers\Api\obatController;
use App\Http\Controllers\Api\transaksiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\logController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::apiResource('kategori', kategoriController::class)->middleware('auth:sanctum');
Route::apiResource('obat', obatController::class);
Route::apiResource('transaksi', transaksiController::class);
Route::get('logs', [logController::class, 'index']);