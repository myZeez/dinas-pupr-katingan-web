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
            if (!Schema::hasColumn('struktur', 'nip')) {
                $table->string('nip')->nullable()->after('jabatan');
            }
            if (!Schema::hasColumn('struktur', 'golongan')) {
                $table->string('golongan')->nullable()->after('nip');
            }
            if (!Schema::hasColumn('struktur', 'status')) {
                $table->string('status')->default('aktif')->after('urutan');
            }
            if (!Schema::hasColumn('struktur', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('foto');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur', function (Blueprint $table) {
            $table->dropColumn(['nip', 'golongan', 'status', 'keterangan']);
        });
    }
};
