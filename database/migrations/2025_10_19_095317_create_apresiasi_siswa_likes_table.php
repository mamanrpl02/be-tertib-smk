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
        Schema::create('apresiasi_siswa_likes', function (Blueprint $table) {
            $table->id();

            // 🔗 Relasi ke tabel apresiasis
            $table->foreignId('apresiasi_id')
                ->constrained('apresiasis')
                ->cascadeOnDelete();

            // 🔗 Relasi ke tabel siswas
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnDelete();

            $table->timestamps();

            // 🔒 Mencegah siswa yang sama like dua kali
            $table->unique(['apresiasi_id', 'siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apresiasi_siswa_likes');
    }
};
