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
            $table->string('nip', 50)->change();
            $table->string('golongan', 100)->change();
            $table->string('jabatan', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur', function (Blueprint $table) {
            $table->string('nip', 20)->change();
            $table->string('golongan', 50)->change();
            $table->string('jabatan', 100)->change();
        });
    }
};
