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
        // Drop existing table
        Schema::dropIfExists('captcha_settings');

        // Create simplified table
        Schema::create('captcha_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default values
        DB::table('captcha_settings')->insert([
            [
                'key' => 'nocaptcha_sitekey',
                'value' => env('NOCAPTCHA_SITEKEY', ''),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'nocaptcha_secret',
                'value' => env('NOCAPTCHA_SECRET', ''),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'captcha_required',
                'value' => env('CAPTCHA_REQUIRED', '1'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captcha_settings');

        // Recreate original complex table
        Schema::create('captcha_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('label');
            $table->text('description')->nullable();
            $table->json('options')->nullable();
            $table->boolean('is_sensitive')->default(false);
            $table->timestamps();
        });
    }
};
