<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// FORCE PHP settings for very large file uploads (up to 2GB) - HIGH PRIORITY
@ini_set('upload_max_filesize', '2048M'); // 2GB in MB
@ini_set('post_max_size', '2048M'); // 2GB in MB  
@ini_set('max_execution_time', '600'); // 10 minutes
@ini_set('memory_limit', '512M'); // 512MB
@ini_set('max_input_time', '600'); // 10 minutes
@ini_set('max_file_uploads', '20');

// Alternative approach with different units
@ini_set('upload_max_filesize', '2G');
@ini_set('post_max_size', '2G');

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());
