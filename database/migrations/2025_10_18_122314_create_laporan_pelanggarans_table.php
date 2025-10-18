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
        Schema::create('laporan_pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('pelanggaran_id')->constrained('pelanggarans')->cascadeOnDelete();
            $table->boolean('fl_beranda')->default(false); // tampil di beranda atau tidak
            $table->boolean('fl_toleransi')->default(false); // apakah masih diberi toleransi
            $table->text('deskripsi')->nullable(); // keterangan tambahan
            $table->string('bukti_pelanggaran')->nullable(); // upload bukti (foto/dokumen)
            $table->enum('status_laporan', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('created_by')->nullable(); // bisa siswa atau user
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pelanggarans');
    }
};
