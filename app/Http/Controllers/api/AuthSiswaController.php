<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;

class AuthSiswaController extends Controller
{
    public function login(Request $request)
    {
        $siswa = Siswa::where('email', $request->email)->first();

        if (! $siswa || ! Hash::check($request->password, $siswa->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // hapus token lama agar 1 siswa cuma punya 1 session aktif
        $siswa->tokens()->delete();

        $token = $siswa->createToken('token_siswa', ['*'], now()->addWeek())->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'siswa' => $siswa,
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }
}
