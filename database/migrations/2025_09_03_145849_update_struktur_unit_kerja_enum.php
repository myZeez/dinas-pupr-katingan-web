<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change unit_kerja from enum to string to allow more flexibility
        Schema::table('struktur', function (Blueprint $table) {
            $table->string('unit_kerja', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur', function (Blueprint $table) {
            $table->enum('unit_kerja', [
                'sekretariat',
                'bidang_bina_marga',
                'bidang_cipta_karya',
                'bidang_sumber_daya_air',
                'bidang_tata_ruang',
                'dinas_pupr'
            ])->default('dinas_pupr')->change();
        });
    }
};
