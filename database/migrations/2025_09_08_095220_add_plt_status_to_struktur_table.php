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
        Schema::table('struktur', function (Blueprint $table) {
            if (!Schema::hasColumn('struktur', 'plt_status')) {
                $table->enum('plt_status', ['aktif', 'tidak_aktif', 'selesai'])->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur', function (Blueprint $table) {
            $table->dropColumn('plt_status');
        });
    }
};
