<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_pelanggaran_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_pelanggaran_id')->constrained('laporan_pelanggarans')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['laporan_pelanggaran_id', 'siswa_id']); // biar gak dobel
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_pelanggaran_siswa');
    }
};
