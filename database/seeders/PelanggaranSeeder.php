<?php

namespace Database\Seeders;

use App\Models\Pelanggaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataKelasSiswa = [
            [
                'ayat' => 1,
                'pelanggaran' => 'Terlambat Masuk Sekolah',
                'poin' => 2,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'ayat' => 1,
                'pelanggaran' => 'Tidak Memakai Seragam',
                'poin' => 2,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'ayat' => 1,
                'pelanggaran' => 'Tidak Membawa Alat Tulis',
                'poin' => 2,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($dataKelasSiswa as $data) {
            Pelanggaran::create($data);
        }
    }
}
