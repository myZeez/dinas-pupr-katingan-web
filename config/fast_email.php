<?php

/*
 * KONFIGURASI OPTIMASI EMAIL CEPAT
 * =================================
 * File untuk mengoptimalkan performa email notification
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Fast Email Configuration
    |--------------------------------------------------------------------------
    | Konfigurasi untuk optimasi pengiriman email notifikasi
    |
    */

    'fast_email' => [
        // Cache settings
        'admin_cache_duration' => 300, // 5 minutes in seconds

        // Email settings
        'bulk_email_enabled' => true,
        'use_bcc_for_multiple_recipients' => true,
        'fallback_to_log_on_failure' => true,

        // Performance settings
        'max_recipients_per_email' => 10,
        'email_timeout' => 10, // seconds
        'retry_attempts' => 1,

        // Template settings
        'use_simple_text_format' => true,
        'include_admin_panel_link' => true,

        // Monitoring
        'log_performance_metrics' => true,
        'performance_threshold_ms' => 3000, // Log if email takes longer than 3 seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    | Optimasi cache untuk performa yang lebih baik
    |
    */

    'cache_optimization' => [
        'admin_emails' => [
            'key' => 'fast_email_admin_emails',
            'duration' => 300, // 5 minutes
        ],

        'email_templates' => [
            'key_prefix' => 'fast_email_template_',
            'duration' => 3600, // 1 hour
        ],

        'performance_stats' => [
            'key' => 'fast_email_performance',
            'duration' => 86400, // 24 hours
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Templates
    |--------------------------------------------------------------------------
    | Template konfigurasi untuk email cepat
    |
    */

    'templates' => [
        'pengaduan' => [
            'subject_prefix' => '🚨 Pengaduan Baru: ',
            'include_category_in_subject' => true,
            'max_subject_length' => 100,
        ],

        'kontak' => [
            'subject_prefix' => '💬 Pesan Kontak Baru: ',
            'include_subject_in_subject' => true,
            'max_subject_length' => 100,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Configuration
    |--------------------------------------------------------------------------
    | Konfigurasi jika pengiriman email gagal
    |
    */

    'fallback' => [
        'enabled' => true,
        'log_channel' => 'daily',
        'log_level' => 'info',
        'include_full_data' => true,

        'notification_methods' => [
            'log' => true,
            'database' => false, // Could implement later
            'slack' => false,   // Could implement later
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Monitoring
    |--------------------------------------------------------------------------
    | Monitor performa pengiriman email
    |
    */

    'monitoring' => [
        'enabled' => true,
        'log_slow_emails' => true,
        'slow_threshold_ms' => 3000,

        'metrics' => [
            'track_send_time' => true,
            'track_success_rate' => true,
            'track_cache_hits' => true,
        ],

        'alerts' => [
            'enabled' => false,
            'failure_rate_threshold' => 0.5, // 50% failure rate
            'slow_email_threshold' => 5000,  // 5 seconds
        ]
    ]
];
