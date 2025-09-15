<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains security settings for the DINAS PUPR application.
    | These settings control various security features and protections.
    |
    */

    'headers' => [
        // Content Security Policy
        'csp' => [
            'enabled' => true,
            'policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: https:; connect-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';"
        ],

        // X-Frame-Options
        'frame_options' => 'DENY',

        // X-Content-Type-Options
        'content_type_options' => 'nosniff',

        // X-XSS-Protection
        'xss_protection' => '1; mode=block',

        // Referrer Policy
        'referrer_policy' => 'strict-origin-when-cross-origin',

        // Strict Transport Security
        'hsts' => [
            'enabled' => true,
            'max_age' => 31536000, // 1 year
            'include_subdomains' => true,
            'preload' => true
        ],

        // Permissions Policy
        'permissions_policy' => 'geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), accelerometer=(), gyroscope=()',
    ],

    'brute_force' => [
        // Maximum login attempts per IP
        'max_attempts' => 5,

        // Time window in minutes
        'time_window' => 15,

        // Lockout duration in minutes
        'lockout_duration' => 60,

        // Cache prefix for storing attempts
        'cache_prefix' => 'brute_force_protection',
    ],

    'sql_injection' => [
        // Enable SQL injection protection
        'enabled' => true,

        // Suspicious patterns to detect
        'patterns' => [
            // SQL injection patterns
            '/(\b(union|select|insert|update|delete|drop|create|alter|exec|execute)\b)/i',
            '/(\b(or|and)\s+\d+\s*=\s*\d+)/i',
            '/(\'\s*(or|and)\s*\')/i',
            '/(-{2}|\/\*|\*\/)/i',

            // XSS patterns
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i',
            '/javascript:/i',
            '/on\w+\s*=/i',

            // File inclusion patterns
            '/\.\.[\/\\\\]/i',
            '/etc\/passwd/i',
            '/proc\/self\/environ/i',
        ],

        // Log suspicious attempts
        'log_attempts' => true,
    ],

    'session' => [
        // Enable session hijacking protection
        'hijack_protection' => true,

        // Admin session timeout (minutes)
        'admin_timeout' => 60,

        // Regular user session timeout (minutes)
        'user_timeout' => 120,

        // Enable IP validation
        'validate_ip' => true,

        // Enable User Agent validation
        'validate_user_agent' => true,
    ],

    'monitoring' => [
        // Enable security monitoring
        'enabled' => true,

        // Suspicious activity threshold
        'suspicious_threshold' => 10,

        // Rate limiting (requests per minute)
        'rate_limit' => 60,

        // Log all admin access
        'log_admin_access' => true,

        // Suspicious patterns to monitor
        'suspicious_patterns' => [
            'wp-admin',
            'wp-login',
            'phpmyadmin',
            'admin.php',
            'login.php',
            'xmlrpc.php',
            'wp-config.php',
            '.env',
            'config.php',
            'database.php',
            '../',
            '..\/',
            '....',
            '%2e%2e',
            '%252e%252e',
            'eval(',
            'base64_decode',
            'shell_exec',
            'system(',
            'exec(',
            'union select',
            'drop table',
            'insert into',
            'delete from',
            '<script',
            'javascript:',
            'onerror=',
            'onload=',
        ],
    ],

    'csrf' => [
        // Enhanced CSRF protection
        'enhanced_protection' => true,

        // Validate referer header
        'validate_referer' => true,

        // Cookie settings
        'cookie_settings' => [
            'secure' => true,
            'http_only' => true,
            'same_site' => 'strict'
        ],
    ],

    'roles' => [
        // Define user roles
        'super_admin' => 'super_admin',
        'user' => 'user',

        // Default role for new users
        'default_role' => 'user',

        // Admin routes that require super_admin role
        'admin_routes_prefix' => 'admin',

        // Role yang dianggap sebagai admin untuk BlockPublicAccessMiddleware
        'admin_roles' => ['super_admin'], // Sesuai dengan database enum saat ini
    ],

    'logging' => [
        // Security log channel
        'channel' => 'security',

        // Log levels for different events
        'levels' => [
            'sql_injection' => 'warning',
            'xss_attempt' => 'warning',
            'brute_force' => 'warning',
            'session_hijack' => 'warning',
            'suspicious_activity' => 'warning',
            'admin_access' => 'info',
            'security_block' => 'critical',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Threat Detection Patterns
    |--------------------------------------------------------------------------
    |
    | Centralized security threat patterns untuk digunakan di middleware.
    | Memudahkan maintenance dan audit security rules.
    |
    */
    'threat_patterns' => [
        // SQL Injection patterns
        'sql' => [
            'union',
            'select',
            'insert',
            'update',
            'delete',
            'drop',
            'alter',
            'create',
            'exec',
            'execute',
            'information_schema',
            'sysobjects',
            'concat',
            'char(',
            'ascii(',
            'substring(',
            'cast('
        ],

        // Path Traversal patterns
        'path' => [
            '../',
            '..\\',
            '%2e%2e',
            '%2f',
            '%5c',
            '/etc/',
            '/proc/',
            '/var/',
            'boot.ini',
            'win.ini',
            '.htaccess',
            '.env',
            'passwd'
        ],

        // XSS patterns
        'xss' => [
            '<script',
            '</script',
            'javascript:',
            'eval(',
            'alert(',
            'confirm(',
            'prompt(',
            'onload=',
            'onerror=',
            'onclick=',
            'onmouseover=',
            'document.cookie',
            'document.write'
        ],

        // Command Injection patterns
        'command' => [
            'system(',
            'exec(',
            'shell_exec(',
            'passthru(',
            'proc_open(',
            '`',
            '&&',
            '||',
            '; rm ',
            '; del ',
            '; cat ',
            '; ls ',
            '; pwd',
            '; whoami',
            '; id',
            '|nc ',
            '|netcat',
            'wget ',
            'curl '
        ],

        // File inclusion patterns
        'inclusion' => [
            'include(',
            'require(',
            'include_once(',
            'require_once(',
            'file_get_contents(',
            'fopen(',
            'readfile(',
            'file('
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Safe Routes Configuration  
    |--------------------------------------------------------------------------
    |
    | Routes yang dianggap aman dan tidak perlu deep scanning
    |
    */
    'safe_routes' => [
        // Auth & system util
        'home',
        'login',
        'logout',
        'password/reset',
        'up',
        '_debugbar',

        // Admin routes - Authenticated and protected by middleware
        'admin',
        'admin/',
        'admin/dashboard',
        'admin/berita',
        'admin/program',
        'admin/layanan',
        'admin/profil',
        'admin/struktur',
        'admin/public-content',
        'admin/pengaduan',
        'admin/ulasan',
        'admin/users',
        'admin/account',
        'dashboard',

        // Static / asset buckets
        'build/',
        'build/assets/',
        'img/',
        'css/',
        'js/',
        'storage/',
        'favicon.ico',

        // Public pages (content sections)  
        'berita',
        'program',
        'layanan',
        'profil',
        'struktur',
        'pengaduan',
        'ulasan',
        'tracking'
    ],

    /*
    |--------------------------------------------------------------------------
    | Threat Severity Configuration
    |--------------------------------------------------------------------------
    |
    | Severity levels untuk different threat types
    |
    */
    'threat_severity' => [
        'sql' => 'critical',
        'command' => 'critical',
        'path' => 'high',
        'inclusion' => 'high',
        'xss' => 'medium'
    ]
];
