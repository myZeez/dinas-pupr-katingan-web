<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Helpers\ImageHelper;

// Debug route untuk testing image storage
Route::get('/debug-image/{filename?}', function ($filename = 'test.jpg') {
    return response()->json(ImageHelper::debugImageStorage($filename, 'konten-public'));
})->name('debug.image');

// Debug route untuk LOGO.png requests
Route::get('/img/LOGO.png', function () {
    Log::info('🚨 LOGO.png was requested!', [
        'url' => request()->fullUrl(),
        'referer' => request()->header('referer'),
        'user_agent' => request()->header('user-agent'),
        'ip' => request()->ip(),
        'timestamp' => now()->toDateTimeString()
    ]);

    return response('LOGO.png no longer exists. Check your favicon implementation.', 404)
           ->header('Content-Type', 'text/plain');
})->name('debug.logo');
