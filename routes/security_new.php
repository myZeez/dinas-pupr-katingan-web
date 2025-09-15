<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Security Routes - Optimized Structure
|--------------------------------------------------------------------------
| Routes khusus untuk memblokir akses unauthorized.
| Menggunakan middleware yang sudah dioptimalkan.
*/

// Block registration routes completely
Route::middleware(['block.registration'])->group(function () {
    Route::get('register', function () {
        // Middleware akan handle blocking
    })->name('register');

    Route::post('register', function () {
        // Middleware akan handle blocking
    });
});

// Admin redirect route dengan protection
Route::get('admin', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['admin.protected'])->name('admin');

// Security check endpoint
Route::get('security-check', function () {
    return response()->json([
        'status' => 'Security Active',
        'timestamp' => now(),
        'protection_level' => 'Maximum'
    ])->header('X-Security-Level', 'Maximum');
});
