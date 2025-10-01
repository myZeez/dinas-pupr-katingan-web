<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicPengaduanController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Admin\StrukturController;
use App\Http\Controllers\Admin\AdminPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// CSRF Refresh Route
Route::get('/csrf-refresh', function () {
    return response()->json([
        'token' => csrf_token(),
        'session_id' => session()->getId()
    ]);
})->name('csrf.refresh');

// ====================
// Public Routes
// ====================
Route::prefix('/')->name('public.')->group(function () {
    // Home
    Route::get('/', [PublicController::class, 'home'])->name('home');
    Route::get('/home', fn() => redirect()->route('public.home'))->name('legacy.home');
    Route::get('/index', fn() => redirect()->route('public.home'))->name('legacy.index');

    // Legacy pages
    Route::get('/struktur', [PublicController::class, 'struktur'])->name('struktur');
    Route::get('/program', [PublicController::class, 'program'])->name('program');
    // Layanan feature removed

    // Pengaduan
    Route::post('/pengaduan', [PublicPengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/check', [PublicPengaduanController::class, 'check'])->name('pengaduan.check');

    // Tracking
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::post('/tracking', [TrackingController::class, 'track'])->name('tracking.track');

    // Ulasan
    Route::post('/ulasan', [PublicController::class, 'ulasanStore'])->name('ulasan.store');

    // Konten Publik
    Route::get('/berita', [PublicController::class, 'berita'])->name('berita');
    Route::get('/berita/{slug}', [PublicController::class, 'beritaShow'])->name('berita.show');
    Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
    Route::get('/video', [App\Http\Controllers\VideoController::class, 'index'])->name('video');
    Route::get('/video/{id}', [App\Http\Controllers\VideoController::class, 'show'])->name('video.show');
    Route::get('/unduhan', [PublicController::class, 'unduhan'])->name('unduhan');
    Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');
    Route::post('/kontak', [PublicController::class, 'kontakStore'])->name('kontak.store');

    // Profil routes
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [PublicController::class, 'profil'])->name('index');
        Route::get('/konten', [PublicController::class, 'profilKonten'])->name('konten');
        Route::get('/struktur', [PublicController::class, 'struktur'])->name('struktur');
    });
});

// ====================
// Admin Redirect
// ====================
Route::get('/admin', function () {
    return Auth::check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
});

// Dashboard redirect
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ====================
// Development / Test Routes
// ====================
if (app()->environment('local')) {
    Route::get('/test/berita', [App\Http\Controllers\Admin\KontenController::class, 'testBerita'])->name('test.berita');
    Route::post('/test/berita', [App\Http\Controllers\Admin\KontenController::class, 'storeBerita'])->name('test.berita.store');

    Route::get('/test/auth', function () {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'authenticated' => true,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'has_admin_access' => $user->hasAdminAccess(),
                'is_super_admin' => $user->isSuperAdmin(),
                'intended_redirect' => $user->hasAdminAccess()
                    ? route('admin.dashboard')
                    : route('public.home'),
            ]);
        }
        return response()->json(['authenticated' => false]);
    })->name('test.auth');

    Route::get('/test/current-user', function () {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            try {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status' => $user->status ?? 'unknown',
                    'hasAdminAccess' => $user->hasAdminAccess(),
                    'isSuperAdmin' => $user->isSuperAdmin(),
                    'isAdmin' => $user->isAdmin(),
                    'all_attributes' => $user->toArray(),
                ];
            } catch (\Exception $e) {
                return [
                    'error' => 'Error calling user methods',
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ];
            }
        }
        return ['error' => 'Not authenticated'];
    })->name('test.current-user');
}

// ====================
// Password Reset Routes (Before Auth)
// ====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/forgot-password', [AdminPasswordController::class, 'showForgotPasswordForm'])
        ->name('password.request');

    Route::post('/password/send-reset', [AdminPasswordController::class, 'sendResetEmail'])
        ->name('password.send-reset');

    Route::get('/password/reset/{token}', [AdminPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/password/reset', [AdminPasswordController::class, 'resetPassword'])
        ->name('password.update');
});

// ====================
// Auth & Admin Routes
// ====================
require __DIR__ . '/auth.php';

// Include debug routes (remove in production)
if (app()->environment('local')) {
    require __DIR__ . '/debug.php';
}

// Admin routes are handled in admin.php
require __DIR__ . '/admin.php';

// ====================
// API Documentation Routes
// ====================
Route::get('/api/documentation.json', [App\Http\Controllers\Api\ApiDocumentationController::class, 'getDocumentation'])->name('api.docs.json');
Route::get('/docs', [App\Http\Controllers\Api\ApiDocumentationController::class, 'showDocumentation'])->name('api.docs.ui');
Route::get('/admin/api/docs', function () {
    return redirect('/docs');
})->name('admin.api.docs');
