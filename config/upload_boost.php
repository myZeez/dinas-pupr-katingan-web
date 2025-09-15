<?php
// Emergency PHP Configuration Boot
// Place this at the very beginning of any upload-related script

// Force maximum upload settings
ini_set('upload_max_filesize', '2G');
ini_set('post_max_size', '2G');
ini_set('memory_limit', '1G');
ini_set('max_execution_time', 0);
ini_set('max_input_time', 0);
ini_set('max_file_uploads', 20);

// Do not echo anything here; emitting output during bootstrap breaks JSON/API responses.
// If you need to verify values, use error_log instead (only in local environment).
if (PHP_SAPI === 'cli' || (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'local')) {
    error_log('[upload_boost] upload_max_filesize=' . ini_get('upload_max_filesize'));
    error_log('[upload_boost] post_max_size=' . ini_get('post_max_size'));
    error_log('[upload_boost] memory_limit=' . ini_get('memory_limit'));
}

// Check POST size
if (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
    $post_size = $_SERVER['CONTENT_LENGTH'];
    $max_post = ini_get('post_max_size');

    // Log POST size details for diagnostics without affecting output
    if (PHP_SAPI === 'cli' || (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'local')) {
        error_log('[upload_boost] POST Size: ' . number_format($post_size / 1024 / 1024, 2) . ' MB');
        error_log('[upload_boost] Max POST: ' . $max_post);
    }

    // Convert max_post to bytes
    $max_bytes = $max_post;
    if (strpos($max_post, 'G') !== false) {
        $max_bytes = (int)$max_post * 1024 * 1024 * 1024;
    } elseif (strpos($max_post, 'M') !== false) {
        $max_bytes = (int)$max_post * 1024 * 1024;
    } elseif (strpos($max_post, 'K') !== false) {
        $max_bytes = (int)$max_post * 1024;
    }

    if ($post_size > $max_bytes) {
        // Log limit exceed without echoing to output
        error_log('[upload_boost] ERROR: POST data exceeds limit!');
        $_POST = array(); // Clear POST to prevent errors
        $_FILES = array(); // Clear FILES
    }
}
