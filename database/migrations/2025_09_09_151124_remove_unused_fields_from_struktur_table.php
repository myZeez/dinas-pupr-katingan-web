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
            $table->dropColumn(['alamat', 'email', 'telepon', 'keterangan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur', function (Blueprint $table) {
            $table->string('email')->nullable()->after('unit_kerja');
            $table->string('telepon', 20)->nullable()->after('email');
            $table->text('alamat')->nullable()->after('telepon');
            $table->text('keterangan')->nullable()->after('plt_keterangan');
        });
    }
};
