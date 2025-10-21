<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaProfileController;
use App\Http\Controllers\Api\AuthSiswaController;
use App\Http\Controllers\Api\PasalController;

Route::post('/login-siswa', [AuthSiswaController::class, 'login']);

// Route::middleware('auth:sanctum')->post('/logout-siswa', [AuthSiswaController::class, 'logout']);

Route::middleware('auth:siswa')->post('/logout-siswa', [AuthSiswaController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/siswa', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:siswa')->get('/siswa/profile', [SiswaProfileController::class, 'profile']);
Route::middleware('auth:siswa')->post('/siswa/update-foto', [SiswaProfileController::class, 'updateFoto']);

Route::get('/pasal', [PasalController::class, 'index']);
Route::get('/pasal/{slug}', [PasalController::class, 'show']);

