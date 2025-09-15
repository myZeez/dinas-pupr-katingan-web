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
            // Add PLT columns if they don't exist
            if (!Schema::hasColumn('struktur', 'memerlukan_plt')) {
                $table->boolean('memerlukan_plt')->default(false);
            }
            if (!Schema::hasColumn('struktur', 'plt_struktur_id')) {
                $table->unsignedBigInteger('plt_struktur_id')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'plt_nama_manual')) {
                $table->string('plt_nama_manual')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'plt_jabatan_manual')) {
                $table->string('plt_jabatan_manual')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'plt_asal_instansi')) {
                $table->string('plt_asal_instansi')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'plt_mulai')) {
                $table->date('plt_mulai')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'plt_selesai')) {
                $table->date('plt_selesai')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'plt_keterangan')) {
                $table->text('plt_keterangan')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'telepon')) {
                $table->string('telepon')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (!Schema::hasColumn('struktur', 'unit_kerja')) {
                $table->string('unit_kerja')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur', function (Blueprint $table) {
            $table->dropColumn([
                'memerlukan_plt',
                'plt_struktur_id',
                'plt_nama_manual',
                'plt_jabatan_manual',
                'plt_asal_instansi',
                'plt_mulai',
                'plt_selesai',
                'plt_keterangan',
                'email',
                'telepon',
                'alamat',
                'unit_kerja'
            ]);
        });
    }
};
