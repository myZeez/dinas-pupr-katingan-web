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
        // Drop the permohonan_layanan table completely
        Schema::dropIfExists('permohonan_layanan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate basic table structure if needed to rollback
        Schema::create('permohonan_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_permohonan')->unique();
            $table->string('jenis_layanan');
            $table->string('nama_pemohon');
            $table->string('nik');
            $table->string('email');
            $table->string('telepon');
            $table->text('alamat');
            $table->text('keperluan');
            $table->json('dokumen_persyaratan')->nullable();
            $table->string('status')->default('Diajukan');
            $table->timestamp('tanggal_permohonan');
            $table->text('catatan_admin')->nullable();
            $table->string('file_hasil')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();
        });
    }
};
