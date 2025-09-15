<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Squashed migration untuk database Dinas PUPR
     * Menggabungkan semua migrasi hingga 2025-08-25
     */
    public function up()
    {
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->json('permissions')->nullable();
            $table->string('foto')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('role');
        });

        // Cache table
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // Jobs table
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // Sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Password reset tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Berita table
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('konten');
            $table->string('thumbnail')->nullable();
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->datetime('tanggal_publikasi')->nullable();
            $table->text('excerpt')->nullable();
            $table->json('meta_data')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'tanggal_publikasi']);
        });

        // Program table
        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });

        // Layanan table
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->text('persyaratan')->nullable();
            $table->string('waktu_proses')->nullable();
            $table->string('biaya')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });

        // Struktur table
        Schema::create('struktur', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->enum('unit_kerja', [
                'sekretariat',
                'bidang_bina_marga', 
                'bidang_cipta_karya',
                'bidang_sumber_daya_air',
                'bidang_tata_ruang',
                'dinas_pupr'
            ])->default('dinas_pupr');
            $table->string('foto')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Pengaduan table
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('subjek');
            $table->text('pesan');
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->text('respon')->nullable();
            $table->timestamp('tanggal_respon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Permohonan Layanan table
        Schema::create('permohonan_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_permohonan')->unique();
            $table->foreignId('layanan_id')->constrained('layanan');
            $table->string('nama_pemohon');
            $table->string('email');
            $table->string('telepon');
            $table->string('nik');
            $table->text('alamat');
            $table->text('deskripsi_permohonan');
            $table->json('dokumen_persyaratan')->nullable();
            $table->json('data_tambahan')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->string('file_hasil')->nullable();
            $table->timestamp('tanggal_proses')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Activity Logs table
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_type')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['user_type', 'user_id']);
            $table->index(['model_type', 'model_id']);
        });

        // File Downloads table
        Schema::create('file_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->string('file_type')->nullable();
            $table->integer('download_count')->default(0);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });

        // Konten Public table
        Schema::create('konten_public', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['karosel', 'video', 'mitra']);
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('url')->nullable();
            $table->integer('urutan')->default(0);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->json('pengaturan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['tipe', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('konten_public');
        Schema::dropIfExists('file_downloads');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('permohonan_layanan');
        Schema::dropIfExists('pengaduan');
        Schema::dropIfExists('struktur');
        Schema::dropIfExists('layanan');
        Schema::dropIfExists('program');
        Schema::dropIfExists('berita');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('users');
    }
};