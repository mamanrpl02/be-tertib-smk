<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apresiasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apresiasi_id')->constrained('apresiasis')->cascadeOnDelete();
            $table->boolean('dikecualikan')->default(false);
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apresiasi_siswa');
    }
};
