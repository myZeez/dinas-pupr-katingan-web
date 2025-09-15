<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cache Email Configuration
    |--------------------------------------------------------------------------
    |
    | Optimize email configuration caching to prevent conflicts
    |
    */

    'cache_config' => env('MAIL_CACHE_CONFIG', false),

    /*
    |--------------------------------------------------------------------------
    | Email Fallback Settings
    |--------------------------------------------------------------------------
    |
    | Configure fallback behavior when SMTP fails
    |
    */

    'fallback_to_log' => env('MAIL_FALLBACK_TO_LOG', true),
    'retry_attempts' => env('MAIL_RETRY_ATTEMPTS', 3),
    'retry_delay' => env('MAIL_RETRY_DELAY', 1), // seconds

    /*
    |--------------------------------------------------------------------------
    | SMTP Connection Timeout
    |--------------------------------------------------------------------------
    |
    | Configure SMTP connection timeout
    |
    */

    'smtp_timeout' => env('MAIL_SMTP_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | Enable detailed logging for email debugging
    |
    */

    'debug_enabled' => env('MAIL_DEBUG', false),

];
