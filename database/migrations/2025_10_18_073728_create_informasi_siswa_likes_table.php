<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_siswa_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('informasi_id')
                ->constrained('informasis')
                ->onDelete('cascade');
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->onDelete('cascade');
            $table->timestamps();

            // Untuk mencegah like ganda dari siswa yang sama
            $table->unique(['informasi_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_siswa_likes');
    }
};
