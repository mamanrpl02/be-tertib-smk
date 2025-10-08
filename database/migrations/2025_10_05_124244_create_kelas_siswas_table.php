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
        Schema::create('kelas_siswas', function (Blueprint $table) {
            $table->id();
            $table->enum('tingkat', ['10', '11', '12']);
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->string('wali_kelas')->nullable();
            $table->year('s_ganjil')->nullable();
            $table->year('s_genap')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_siswas');
    }
};
