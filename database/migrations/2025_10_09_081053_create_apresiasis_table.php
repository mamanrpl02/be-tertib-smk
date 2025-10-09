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
            // $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->json('siswa_ids');
            $table->integer('poin');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('fl_beranda')->default(false);
            $table->text('deskripsi');
            $table->string('bukti_laporan')->nullable();
            $table->timestamps(); // created_at & updated_at
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
