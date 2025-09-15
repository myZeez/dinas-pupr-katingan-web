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
        Schema::table('permohonan_layanan', function (Blueprint $table) {
            // Add new fields for enhanced system
            if (!Schema::hasColumn('permohonan_layanan', 'jenis_layanan_code')) {
                $table->string('jenis_layanan_code')->nullable()->after('jenis_layanan');
            }

            if (!Schema::hasColumn('permohonan_layanan', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('keperluan');
            }

            if (!Schema::hasColumn('permohonan_layanan', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('tanggal_permohonan');
            }

            if (!Schema::hasColumn('permohonan_layanan', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }

            if (!Schema::hasColumn('permohonan_layanan', 'admin_id')) {
                $table->unsignedBigInteger('admin_id')->nullable()->after('catatan_admin');
            }

            // Add soft deletes if not exists
            if (!Schema::hasColumn('permohonan_layanan', 'deleted_at')) {
                $table->softDeletes();
            }

            // Add tanggal_selesai if not exists
            if (!Schema::hasColumn('permohonan_layanan', 'tanggal_selesai')) {
                $table->timestamp('tanggal_selesai')->nullable()->after('tanggal_permohonan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_layanan', function (Blueprint $table) {
            $columnsToRemove = [
                'jenis_layanan_code',
                'deskripsi',
                'ip_address',
                'user_agent',
                'admin_id',
                'deleted_at',
                'tanggal_selesai'
            ];

            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('permohonan_layanan', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
