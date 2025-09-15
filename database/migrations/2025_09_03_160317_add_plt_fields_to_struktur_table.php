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
            // Check if columns exist before adding them
            if (!Schema::hasColumn('struktur', 'status_keaktifan')) {
                $table->enum('status_keaktifan', ['aktif', 'pensiun', 'mutasi', 'cuti_panjang'])->default('aktif')->after('status');
            }
            if (!Schema::hasColumn('struktur', 'memerlukan_plt')) {
                $table->boolean('memerlukan_plt')->default(false)->after('status_keaktifan');
            }
            if (!Schema::hasColumn('struktur', 'plt_struktur_id')) {
                $table->unsignedBigInteger('plt_struktur_id')->nullable()->after('memerlukan_plt');
            }
            if (!Schema::hasColumn('struktur', 'plt_nama_manual')) {
                $table->string('plt_nama_manual')->nullable()->after('plt_struktur_id');
            }
            if (!Schema::hasColumn('struktur', 'plt_jabatan_manual')) {
                $table->string('plt_jabatan_manual')->nullable()->after('plt_nama_manual');
            }
            if (!Schema::hasColumn('struktur', 'plt_asal_instansi')) {
                $table->string('plt_asal_instansi')->nullable()->after('plt_jabatan_manual');
            }
            if (!Schema::hasColumn('struktur', 'plt_mulai')) {
                $table->date('plt_mulai')->nullable()->after('plt_asal_instansi');
            }
            if (!Schema::hasColumn('struktur', 'plt_selesai')) {
                $table->date('plt_selesai')->nullable()->after('plt_mulai');
            }
            if (!Schema::hasColumn('struktur', 'plt_keterangan')) {
                $table->text('plt_keterangan')->nullable()->after('plt_selesai');
            }

            // Foreign key untuk PLT dari internal (only add if column was added)
            if (
                !Schema::hasColumn('struktur', 'plt_struktur_id') ||
                Schema::hasColumn('struktur', 'plt_struktur_id')
            ) {
                try {
                    $table->foreign('plt_struktur_id')->references('id')->on('struktur')->onDelete('set null');
                } catch (Exception $e) {
                    // Foreign key might already exist
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur', function (Blueprint $table) {
            $table->dropForeign(['plt_struktur_id']);
            $table->dropColumn([
                'status_keaktifan',
                'memerlukan_plt',
                'plt_struktur_id',
                'plt_nama_manual',
                'plt_jabatan_manual',
                'plt_asal_instansi',
                'plt_mulai',
                'plt_selesai',
                'plt_keterangan'
            ]);
        });
    }
};
