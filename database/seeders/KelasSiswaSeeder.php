<?php

namespace Database\Seeders;

use App\Models\KelasSiswa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dataKelasSiswa = [
            ['tingkat' => '10', 'jurusan_id' => 1, 'wali_kelas' => 1, 's_ganjil' => 2024, 's_genap' => 2025],
            ['tingkat' => '11', 'jurusan_id' => 1, 'wali_kelas' => 1, 's_ganjil' => 2024, 's_genap' => 2025],
            ['tingkat' => '12', 'jurusan_id' => 1, 'wali_kelas' => 1, 's_ganjil' => 2024, 's_genap' => 2025],
            ['tingkat' => '10', 'jurusan_id' => 2, 'wali_kelas' => 1, 's_ganjil' => 2024, 's_genap' => 2025],
            ['tingkat' => '11', 'jurusan_id' => 2, 'wali_kelas' => 1, 's_ganjil' => 2024, 's_genap' => 2025],
            ['tingkat' => '12', 'jurusan_id' => 2, 'wali_kelas' => 1, 's_ganjil' => 2024, 's_genap' => 2025],
        ];

        foreach ($dataKelasSiswa as $data) {
            KelasSiswa::create([
                'tingkat' => $data['tingkat'],
                'jurusan_id' => $data['jurusan_id'],
                'wali_kelas' => $data['wali_kelas'],
                's_ganjil' => $data['s_ganjil'],
                's_genap' => $data['s_genap'],
            ]);
        }
    }
}
