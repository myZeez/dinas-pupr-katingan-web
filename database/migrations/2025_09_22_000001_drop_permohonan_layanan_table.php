<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('permohonan_layanan')) {
            Schema::drop('permohonan_layanan');
        }
    }

    public function down(): void
    {
        // Tidak direstore karena fitur layanan dihapus permanen
    }
};
