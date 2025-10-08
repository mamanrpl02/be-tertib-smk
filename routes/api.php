<?php

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaController;
use Illuminate\Support\Facades\Storage;


// ✅ LOGIN SISWA
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


Route::middleware('auth:sanctum')->get('/siswa', function (Request $request) {
    $siswa = $request->user();

    // Ambil data kelas
    $kelasId = $siswa->tingkat_12 ?? $siswa->tingkat_11 ?? $siswa->tingkat_10;
    $kelas = null;
    if ($kelasId) {
        $kelas = \App\Models\KelasSiswa::with(['jurusan', 'waliKelas'])->find($kelasId);
    }

    // ✅ Bikin URL foto yang bisa dibuka
    $fotoUrl = null;
    if ($siswa->foto_profile) {
        try {
            // coba generate temporary URL 1 hari
            $fotoUrl = Storage::disk('public')->temporaryUrl($siswa->foto_profile, now()->addDay());
        } catch (\Exception $e) {
            // fallback ke asset biasa kalau gagal
            $fotoUrl = asset('storage/' . $siswa->foto_profile);
        }
    }

    return response()->json([
        'id' => $siswa->id,
        'nama' => $siswa->nama,
        'email' => $siswa->email,
        'jenis_kelamin' => $siswa->jenis_kelamin ?? '-',
        'foto' => $fotoUrl, // ✅ gunakan URL valid
        'kelas' => $kelas->tingkat ?? '-',
        'jurusan' => $kelas->jurusan->nama ?? '-',
        'wali_kelas' => $kelas->waliKelas->name ?? '-',
    ]);
});


// ✅ LOGOUT SISWA
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logout berhasil']);
});
