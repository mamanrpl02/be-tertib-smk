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
        KelasSiswa::create([
            'tingkat' => '10',
            'jurusan_id' => 1,
            'wali_kelas' => 1,
            's_ganjil' => 2025,
            's_genap' => 2026,
        ]);
    }
}
