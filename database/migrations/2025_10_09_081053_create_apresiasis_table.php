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
        Schema::create('apresiasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('poin');
            $table->text('deskripsi');
            $table->string('bukti_laporan')->nullable();
            $table->boolean('fl_beranda')->default(false);
            $table->enum('tipe_apresiasi', ['spesifik', 'tingkat', 'tingkat_jurusan'])->nullable();
            $table->enum('tingkat', ['10', '11', '12'])->nullable();
            $table->foreignId('kelas_siswa_id')->nullable()->constrained('kelas_siswas')->nullOnDelete();
            $table->json('siswa_ids')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apresiasis');
    }
};
