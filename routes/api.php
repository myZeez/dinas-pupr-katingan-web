<?php

use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\PengaduanApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Base API Information
Route::get('/info', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API Dinas PUPR is working',
        'version' => '1.0.0',
        'timestamp' => now()->toISOString(),
        'endpoints' => [
            'info' => '/api/info',
            'berita' => '/api/berita',
            'pengaduan' => '/api/pengaduan'
        ]
    ]);
});

// Berita API Routes
Route::get('/berita', [BeritaApiController::class, 'index']);
Route::get('/berita/{id}', [BeritaApiController::class, 'show']);

// Pengaduan API Routes
Route::post('/pengaduan', [PengaduanApiController::class, 'store']);
Route::get('/pengaduan/{nomor_tiket}', [PengaduanApiController::class, 'checkStatus']);
