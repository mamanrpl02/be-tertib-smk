<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('foto_profile')->nullable();
            $table->foreignId('tingkat_10')->nullable()->constrained('kelas_siswas')->nullOnDelete();
            $table->foreignId('tingkat_11')->nullable()->constrained('kelas_siswas')->nullOnDelete();
            $table->foreignId('tingkat_12')->nullable()->constrained('kelas_siswas')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
