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



// ==========================
// 👤 PROFIL SISWA
// ==========================
Route::middleware('auth:sanctum')->get('/siswa', function (Request $request) {
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
