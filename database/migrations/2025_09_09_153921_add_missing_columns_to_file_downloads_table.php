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
            // Check and add missing columns if they don't exist
            if (!Schema::hasColumn('file_downloads', 'nama_file')) {
                $table->string('nama_file', 255)->nullable()->after('id');
            }
            if (!Schema::hasColumn('file_downloads', 'kategori')) {
                $table->string('kategori', 100)->default('dokumen')->after('file_type');
            }
            if (!Schema::hasColumn('file_downloads', 'urutan')) {
                $table->integer('urutan')->default(0)->after('download_count');
            }
            if (!Schema::hasColumn('file_downloads', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('urutan');
                // Add foreign key constraint
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_downloads', function (Blueprint $table) {
            // Drop foreign key first if exists
            if (Schema::hasColumn('file_downloads', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            // Drop other columns if they exist
            $columnsToRemove = ['nama_file', 'kategori', 'urutan'];
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('file_downloads', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
