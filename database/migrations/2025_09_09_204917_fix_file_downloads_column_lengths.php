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
        Schema::table('file_downloads', function (Blueprint $table) {
            // Fix kategori enum to include more options
            $table->enum('kategori', [
                'dokumen',
                'formulir',
                'peraturan',
                'panduan',
                'infrastruktur',
                'perencanaan',
                'pembangunan',
                'pemeliharaan',
                'monitoring',
                'lainnya'
            ])->default('dokumen')->change();

            // Also ensure file_path has enough length
            $table->string('file_path', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_downloads', function (Blueprint $table) {
            // Revert to original enum
            $table->enum('kategori', [
                'dokumen',
                'formulir',
                'peraturan',
                'panduan',
                'lainnya'
            ])->default('dokumen')->change();

            $table->string('file_path', 255)->change();
        });
    }
};
