<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apresiasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('poin');
            $table->text('deskripsi');
            $table->string('bukti_laporan')->nullable();
            $table->boolean('fl_beranda')->default(false);

            // tipe penerima apresiasi
            $table->enum('tipe_apresiasi', ['spesifik', 'tingkat', 'tingkat_jurusan'])->nullable();

            // jika berdasarkan tingkat atau jurusan
            $table->enum('tingkat', ['10', '11', '12'])->nullable();
            $table->foreignId('kelas_siswa_id')->nullable()->constrained('kelas_siswas')->nullOnDelete();

            // audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apresiasis');
    }
};
