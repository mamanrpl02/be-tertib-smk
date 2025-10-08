<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function show(Request $request)
    {
        $siswa = $request->user();

        // Ambil kelas yang aktif (dari relasi siswa -> kelas_siswa)
        $kelasId = $siswa->tingkat_12 ?? $siswa->tingkat_11 ?? $siswa->tingkat_10;

        $kelas = null;
        if ($kelasId) {
            $kelas = \App\Models\KelasSiswa::with(['jurusan', 'waliKelas'])->find($kelasId);
        }

        return response()->json([
            'id' => $siswa->id,
            'nama' => $siswa->nama,
            'email' => $siswa->email,
            'jenis_kelamin' => $siswa->jenis_kelamin ?? '-',
            'foto' => $siswa->foto_profile ? asset('storage/' . $siswa->foto_profile) : null,
            'kelas' => $kelas->tingkat ?? '-',
            'jurusan' => $kelas->jurusan->nama ?? '-',
            'wali_kelas' => $kelas->waliKelas->name ?? '-',
        ]);
    }
}
