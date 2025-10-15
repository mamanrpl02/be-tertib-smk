<?php

namespace Database\Seeders;

use App\Models\KelasSiswa;
use Illuminate\Database\Seeder;

class KelasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataKelasSiswa = [
            [
                'tingkat' => '10',
                'jurusan' => 'Rekayasa Preangkat Lunak (RPL)',
                'sub_kelas' => 'A',
                'wali_kelas' => 1,
                's_ganjil' => 2024,
                's_genap' => 2025,
            ],
            [
                'tingkat' => '11',
                'jurusan' => 'Rekayasa Preangkat Lunak (RPL)',
                'sub_kelas' => 'B',
                'wali_kelas' => 1,
                's_ganjil' => 2024,
                's_genap' => 2025,
            ],
            [
                'tingkat' => '12',
                'jurusan' => 'Rekayasa Preangkat Lunak (RPL)',
                'sub_kelas' => 'C',
                'wali_kelas' => 1,
                's_ganjil' => 2024,
                's_genap' => 2025,
            ],
            [
                'tingkat' => '10',
                'jurusan' => 'Teknik Kendaraan Ringan Otomotif (TKRO)',
                'sub_kelas' => 'A',
                'wali_kelas' => 1,
                's_ganjil' => 2024,
                's_genap' => 2025,
            ],
            [
                'tingkat' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan Otomotif (TKRO)',
                'sub_kelas' => 'B',
                'wali_kelas' => 1,
                's_ganjil' => 2024,
                's_genap' => 2025,
            ],
            [
                'tingkat' => '12',
                'jurusan' => 'Teknik Kendaraan Ringan Otomotif (TKRO)',
                'sub_kelas' => 'C',
                'wali_kelas' => 1,
                's_ganjil' => 2024,
                's_genap' => 2025,
            ],
        ];

        foreach ($dataKelasSiswa as $data) {
            KelasSiswa::create($data);
        }
    }
}
