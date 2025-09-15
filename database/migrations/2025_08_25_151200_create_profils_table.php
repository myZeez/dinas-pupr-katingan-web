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
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi')->default('Dinas Pekerjaan Umum dan Penataan Ruang');
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('tupoksi')->nullable(); // Tugas Pokok dan Fungsi
            $table->text('sejarah')->nullable();
            $table->text('motto')->nullable();
            $table->text('filosofi')->nullable();
            $table->text('nilai_nilai')->nullable(); // Core Values
            $table->text('sasaran')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('kebijakan_mutu')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('jam_operasional')->nullable();
            $table->enum('status', ['aktif', 'draft'])->default('aktif');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
