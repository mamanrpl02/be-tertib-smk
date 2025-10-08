<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;

// ✅ Login siswa
Route::post('/login-siswa', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $siswa = Siswa::where('email', $request->email)->first();

    if (!$siswa || !Hash::check($request->password, $siswa->password)) {
        return response()->json(['message' => 'Email atau password salah'], 401);
    }

    $token = $siswa->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login berhasil',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'siswa' => $siswa,
    ]);
});

// ✅ Data siswa login
Route::middleware('auth:sanctum')->get('/siswa', function (Request $request) {
    return response()->json($request->user());
});

// ✅ Logout siswa
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logout berhasil']);
});
