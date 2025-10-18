<?php

use App\Models\Siswa;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\AuthSiswaController;




Route::post('/login-siswa', [AuthSiswaController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout-siswa', [AuthSiswaController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/siswa', function (Request $request) {
    return $request->user();
});


// ==========================
// 👤 PROFIL SISWA
// ==========================
Route::middleware('auth:sanctum')->get('/siswa/profile', function (Request $request) {
    $siswa = $request->user();

    // Ambil data kelas dari relasi
    $kelasId = $siswa->tingkat_12 ?? $siswa->tingkat_11 ?? $siswa->tingkat_10;
    $kelas = null;

    if ($kelasId) {
        $kelas = \App\Models\KelasSiswa::with(['jurusan', 'waliKelas'])->find($kelasId);
    }

    // Buat URL foto yang valid
    $fotoUrl = null;
    if ($siswa->foto_profile) {
        if (Storage::disk('public')->exists($siswa->foto_profile)) {
            // kalau file ada → kirim URL public
            $fotoUrl = asset('storage/' . $siswa->foto_profile);
        } else {
            // kalau tidak ada → kosongkan
            $fotoUrl = null;
        }
    }

    return response()->json([
        'id' => $siswa->id,
        'nama' => $siswa->nama,
        'email' => $siswa->email,
        'jenis_kelamin' => $siswa->jenis_kelamin ?? '-',
        'foto' => $fotoUrl, // gunakan field seragam
        'kelas' => $kelas->tingkat ?? '-',
        'jurusan' => $kelas->jurusan->nama ?? '-',
        'wali_kelas' => $kelas->waliKelas->name ?? '-',
    ]);
});


// ==========================
// 📸 UPDATE FOTO PROFIL
// ==========================
Route::middleware('auth:sanctum')->post('/siswa/update-foto', function (Request $request) {
    $request->validate([
        'foto' => 'required|image|max:2048',
    ]);

    $siswa = $request->user();

    // Hapus foto lama jika ada
    if ($siswa->foto_profile && Storage::disk('public')->exists($siswa->foto_profile)) {
        Storage::disk('public')->delete($siswa->foto_profile);
    }

    // Simpan foto baru ke folder public/foto_siswa
    $path = $request->file('foto')->store('foto_siswa', 'public');

    // Update path foto di database
    $siswa->update(['foto_profile' => $path]);

    // Buat URL public untuk dikembalikan ke frontend
    $url = asset('storage/' . $path);

    return response()->json([
        'message' => 'Foto profil berhasil diperbarui.',
        'foto' => $url,
    ]);
});

// ✅ LOGOUT SISWA
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logout berhasil']);
});
