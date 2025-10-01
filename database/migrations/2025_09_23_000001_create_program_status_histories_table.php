<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program')->onDelete('cascade');
            $table->string('status_lama')->nullable();
            $table->string('status_baru');
            $table->string('trigger_type')->comment('manual, auto_date, auto_scheduler');
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_perubahan');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();

            $table->index(['program_id', 'tanggal_perubahan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_status_histories');
    }
};
