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
        Schema::create('public_content_news', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['karousel', 'video', 'mitra'])->default('karousel');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size')->nullable();
            $table->integer('urutan')->default(0);
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tipe', 'status', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_content_news');
    }
};
