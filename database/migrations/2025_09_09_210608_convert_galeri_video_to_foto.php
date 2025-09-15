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
        // Update all video records to foto
        DB::table('galeris')->where('tipe', 'video')->update(['tipe' => 'foto']);

        // Update enum to only allow foto
        Schema::table('galeris', function (Blueprint $table) {
            $table->enum('tipe', ['foto'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore original enum with video option
        Schema::table('galeris', function (Blueprint $table) {
            $table->enum('tipe', ['foto', 'video'])->change();
        });
    }
};
