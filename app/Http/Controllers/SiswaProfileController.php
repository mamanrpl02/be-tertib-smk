<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\KelasSiswa;

class SiswaProfileController extends Controller
{
    // ==========================
    // 👤 Ambil Profil Siswa
    // ==========================
    public function profile(Request $request)
    {
        $siswa = $request->user();

        // Tentukan kelas aktif (prioritas: 12 > 11 > 10)
        $kelasAktifId = $siswa->tingkat_12 ?? $siswa->tingkat_11 ?? $siswa->tingkat_10;

        $kelasAktif = null;
        $jurusan = '-';
        $waliKelas = '-';
        $namaKelas = '-';
        $subKelas = '-';

        if ($kelasAktifId) {
            $kelasAktif = \App\Models\KelasSiswa::with('waliKelas')->find($kelasAktifId);

            if ($kelasAktif) {
                $namaKelas = $kelasAktif->tingkat ?? '-';
                $jurusan = $kelasAktif->jurusan ?? '-';
                $subKelas = $kelasAktif->sub_kelas ?? '-';
                $waliKelas = $kelasAktif->waliKelas->name ?? '-';
            }
        }

        // Gabungkan nama kelas + sub kelas
        $kelasLengkap = trim("{$namaKelas} {$subKelas}");
        if ($kelasLengkap === '') $kelasLengkap = '-';

        return response()->json([
            'id'            => $siswa->id,
            'nama'          => $siswa->nama,
            'email'         => $siswa->email,
            'jenis_kelamin' => $siswa->jenis_kelamin ?? '-',
            'kelas'         => $kelasLengkap,
            'jurusan'       => $jurusan,
            'wali_kelas'    => $waliKelas,
            'foto_profile'  => $siswa->foto_profile ? asset('storage/' . $siswa->foto_profile) : null,
        ]);
    }

    // ==========================
    // 📸 Update Foto Profil
    // ==========================
    public function updateFoto(Request $request)
    {
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

        $url = asset('storage/' . $path);

        return response()->json([
            'message' => 'Foto profil berhasil diperbarui.',
            'foto' => $url,
        ]);
    }
}
