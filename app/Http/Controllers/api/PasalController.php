<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pasal;

class PasalController extends Controller
{
    public function index()
    {
        $pasals = Pasal::select('id', 'nama_pasal', 'judul', 'deskripsi')
            ->orderBy('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pasals
        ]);
    }

    public function show($slug)
    {
        // Contoh input: "pasal-3"
        $slug = strtolower(trim($slug));

        // Ambil nomor pasal dari slug (misal: pasal-3 → 3)
        $nomor = str_replace('pasal-', '', $slug);

        // Cari pasal berdasarkan nama_pasal di DB
        $pasal = Pasal::with('pelanggarans')
            ->where('nama_pasal', 'Pasal ' . $nomor)
            ->first();

        if (!$pasal) {
            return response()->json([
                'message' => 'Pasal tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'id' => $pasal->id,
            'nama_pasal' => $pasal->nama_pasal,
            'judul' => $pasal->judul,
            'deskripsi' => $pasal->deskripsi,
            'pelanggaran' => $pasal->pelanggarans->map(fn($p) => [
                'ayat' => $p->ayat . '. ' . $p->pelanggaran,
                'poin' => $p->poin
            ]),
        ]);
    }
}
