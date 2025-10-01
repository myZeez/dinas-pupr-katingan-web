<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Simple Captcha Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for simple math-based captcha system
    |
    */

    'required' => env('CAPTCHA_REQUIRED', true),

    'operations' => [
        'addition' => true,
        'subtraction' => true,
        'multiplication' => true,
    ],

    'difficulty' => [
        'min_number' => 1,
        'max_number' => 50,
        'multiplication_max' => 12, // Keep multiplication tables simple
    ],

    'session_key_prefix' => 'simple_captcha_',
    'session_lifetime' => 600, // 10 minutes
];
