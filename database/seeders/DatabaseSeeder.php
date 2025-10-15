<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\KelasSiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Maman',
            'email' => 'maman@tertib.com',
            'password' => bcrypt('12341234'),
        ]);
        
        $this->call([
            KelasSiswaSeeder::class,
        ]);
        $this->call(SiswaSeeder::class);
        // $this->call(ApresiasiSeeder::class);
    }
}
