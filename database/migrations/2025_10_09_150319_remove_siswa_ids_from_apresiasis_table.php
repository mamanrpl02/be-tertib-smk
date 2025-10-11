<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apresiasis', function (Blueprint $table) {
            if (Schema::hasColumn('apresiasis', 'siswa_ids')) {
                $table->dropColumn('siswa_ids');
            }
        });
    }

    public function down(): void
    {
        Schema::table('apresiasis', function (Blueprint $table) {
            $table->json('siswa_ids')->nullable(); // jika rollback, kembalikan
        });
    }
};
