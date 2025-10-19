<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_siswa_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_pelanggaran_id')->constrained()->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['laporan_pelanggaran_id', 'siswa_id']); // biar gak bisa like dua kali
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_siswa_likes');
    }
};
