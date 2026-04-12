<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\kategoriController;
use App\Http\Controllers\Api\obatController;
use App\Http\Controllers\Api\transaksiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\logController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\UserController;

// Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');
    
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
Route::apiResource('kategori', kategoriController::class)->middleware('auth:sanctum');
Route::apiResource('obat', obatController::class)->middleware('auth:sanctum');
Route::apiResource('transaksi', transaksiController::class)->middleware('auth:sanctum');
Route::get('logs', [logController::class, 'index'])->middleware('auth:sanctum');
Route::get('/laporan', [LaporanController::class, 'index'])->middleware('auth:sanctum');
Route::get('getUser', [UserController::class, 'getUser'])->middleware('auth:sanctum');
Route::get('countObat', [ObatController::class, 'getCountObat'])->middleware('auth:sanctum');
Route::get('countKategori', [kategoriController::class, 'getKategori'])->middleware('auth:sanctum');
Route::get('getDateObat', [obatController::class, 'getDateObat'])->middleware('auth:sanctum');