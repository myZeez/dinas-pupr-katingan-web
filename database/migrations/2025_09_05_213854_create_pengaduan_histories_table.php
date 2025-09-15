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
        Schema::create('pengaduan_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->onDelete('cascade');
            $table->string('status_from')->nullable(); // Status sebelumnya
            $table->string('status_to'); // Status baru
            $table->string('action'); // Dibuat, Diubah, Ditolak, Selesai
            $table->text('keterangan')->nullable(); // Catatan tambahan
            $table->string('admin_name')->nullable(); // Nama admin yang mengubah
            $table->string('admin_email')->nullable(); // Email admin yang mengubah
            $table->timestamps();

            // Index untuk performa query
            $table->index(['pengaduan_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan_histories');
    }
};
