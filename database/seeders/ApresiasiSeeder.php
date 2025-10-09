<?php

namespace Database\Seeders;

use App\Models\Apresiasi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApresiasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apresiasi::create([
            'nama' => 'Disiplin Datang Tepat Waktu',
            'siswa_ids' => [1, 2, 3], // ID siswa dalam bentuk array
            'poin' => 5,
            'deskripsi' => 'Apresiasi untuk siswa yang selalu datang tepat waktu selama seminggu penuh.',
            'bukti_laporan' => null,
            'fl_beranda' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
