<?php

// Emergency PHP Upload Configuration Boost
require_once __DIR__ . '/../config/upload_boost.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/security_new.php'));
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        /*
        |--------------------------------------------------------------------------
        | Security Middleware Aliases
        |--------------------------------------------------------------------------
        | Alias untuk middleware security yang dapat digunakan di routes
        */
        $middleware->alias([
            // Auth & Authorization
            'super.admin' => \App\Http\Middleware\Auth\SuperAdminMiddleware::class,
            'block.registration' => \App\Http\Middleware\Auth\BlockRegistrationMiddleware::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'role.session' => \App\Http\Middleware\RoleBasedSessionMiddleware::class,

            // Security Protection
            'security.headers' => \App\Http\Middleware\Security\SecurityHeadersMiddleware::class,
            'request.sanitizer' => \App\Http\Middleware\Security\RequestSanitizerMiddleware::class,
            'brute.force.protection' => \App\Http\Middleware\Security\BruteForceProtectionMiddleware::class,
            'security.monitoring' => \App\Http\Middleware\Security\SecurityMonitoringMiddleware::class,
            'blockPublicAccess' => \App\Http\Middleware\Security\BlockPublicAccessMiddleware::class,

            // API Middleware
            'api.cors' => \App\Http\Middleware\ApiCorsMiddleware::class,

            // Activity Logging
            'log.admin.activity' => \App\Http\Middleware\LogAdminActivity::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Global Middleware Stack
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | Global Middleware Stack
        |--------------------------------------------------------------------------
        */

        // Ensure CSRF middleware is registered for web routes
        $middleware->validateCsrfTokens(except: [
            'api/*',
            'webhook/*',
        ]);

        $middleware->web(append: [
            // CSRF protection is automatically included in Laravel's default web middleware
            // \App\Http\Middleware\Security\SecurityHeadersMiddleware::class,
            // \App\Http\Middleware\Security\RequestSanitizerMiddleware::class,
        ]);

        $middleware->api(append: [
            \App\Http\Middleware\ApiCorsMiddleware::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Middleware Groups
        |--------------------------------------------------------------------------
        | Group middleware untuk use cases spesifik
        */

        // Admin protection group
        $middleware->group('admin.protected', [
            'auth',
            'role.session',
            'role:any_admin',
            'security.monitoring',
        ]);

        // Login protection group  
        $middleware->group('login.protected', [
            'brute.force.protection',
            'security.monitoring',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Route-Specific Middleware
        |--------------------------------------------------------------------------
        | Untuk rate limiting, gunakan throttle middleware di routes langsung
        */
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
