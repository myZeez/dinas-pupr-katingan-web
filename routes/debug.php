<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\ImageHelper;

// Debug route untuk testing image storage
Route::get('/debug-image/{filename?}', function ($filename = 'test.jpg') {
    return response()->json(ImageHelper::debugImageStorage($filename, 'konten-public'));
})->name('debug.image');
