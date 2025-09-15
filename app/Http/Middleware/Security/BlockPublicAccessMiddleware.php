<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Block Public Access Middleware
 * 
 * Middleware untuk memblokir akses ke halaman login admin dan route tertentu
 * jika user tidak memiliki hak akses yang sesuai.
 * 
 * Fungsi utama:
 * - Memblokir akses ke /login dan halaman admin untuk user non-admin
 * - Memberikan response 403 Forbidden untuk akses yang tidak diizinkan
 * - Logging untuk monitoring security access
 * 
 * @package App\Http\Middleware\Security
 * @author DINAS PUPR Katingan Security Team
 * @version 1.0
 */
class BlockPublicAccessMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * Mengecek apakah user memiliki hak akses untuk mengakses route tertentu.
     * Jika tidak memiliki hak akses, akan mengembalikan response 403 Forbidden.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Step 1: Ambil path dari request yang sedang diakses
        $path = $request->path();
        $method = $request->method();

        // Step 2: Definisikan route yang dibatasi aksesnya
        $restrictedRoutes = [
            'login',           // Halaman login admin
            'admin',           // Route admin utama
            'admin/dashboard', // Dashboard admin
            'dashboard',       // Redirect dashboard
        ];

        // Step 3: Cek apakah route yang diakses termasuk dalam restricted routes
        $isRestrictedRoute = $this->isRestrictedRoute($path, $restrictedRoutes);

        if ($isRestrictedRoute) {
            // Step 4: Cek status autentikasi user
            if (!Auth::check()) {
                // User belum login - blokir akses
                $this->logBlockedAccess($request, 'unauthenticated', null);

                return $this->createForbiddenResponse(
                    'Akses ditolak. Anda harus login terlebih dahulu.'
                );
            }

            // Step 5: Ambil data user yang sudah terautentikasi
            $user = Auth::user();

            // Step 6: Cek role user - hanya admin yang diizinkan
            if (!$this->isUserAdmin($user)) {
                // User bukan admin - blokir akses
                $this->logBlockedAccess($request, 'insufficient_privileges', $user);

                return $this->createForbiddenResponse(
                    'Akses ditolak. Anda tidak memiliki hak akses administrator.'
                );
            }

            // Step 7: Log akses yang berhasil (opsional, hanya di development)
            if (app()->environment('local')) {
                $this->logSuccessfulAccess($request, $user);
            }
        }

        // Step 8: Lanjutkan request jika semua validasi berhasil
        return $next($request);
    }

    /**
     * Mengecek apakah route yang diakses termasuk dalam restricted routes
     * 
     * @param string $path
     * @param array $restrictedRoutes
     * @return bool
     */
    private function isRestrictedRoute(string $path, array $restrictedRoutes): bool
    {
        foreach ($restrictedRoutes as $restrictedRoute) {
            // Exact match atau starts with untuk route admin/*
            if ($path === $restrictedRoute || str_starts_with($path, $restrictedRoute . '/')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mengecek apakah user memiliki role admin
     * 
     * @param mixed $user
     * @return bool
     */
    private function isUserAdmin($user): bool
    {
        // Cek jika user object memiliki property role
        if (!isset($user->role)) {
            return false;
        }

        // Daftar role yang dianggap sebagai admin
        // Baca dari konfigurasi untuk fleksibilitas
        $adminRoles = config('security.roles.admin_roles', ['super_admin']);

        return in_array($user->role, $adminRoles);
    }

    /**
     * Membuat response 403 Forbidden
     * 
     * @param string $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function createForbiddenResponse(string $message): Response
    {
        // Cek jika request mengharapkan JSON response (API)
        if (request()->expectsJson()) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => $message,
                'status_code' => 403
            ], 403);
        }

        // Return HTML response untuk web request
        return response()->view('errors.403', [
            'message' => $message
        ], 403);
    }

    /**
     * Log akses yang diblokir untuk monitoring security
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $reason
     * @param mixed $user
     * @return void
     */
    private function logBlockedAccess(Request $request, string $reason, $user = null): void
    {
        $logData = [
            'middleware' => 'BlockPublicAccess',
            'action' => 'access_blocked',
            'reason' => $reason,
            'ip' => $request->ip(),
            'path' => $request->path(),
            'method' => $request->method(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ];

        // Tambahkan info user jika tersedia
        if ($user) {
            $logData['user_id'] = $user->id;
            $logData['user_email'] = $user->email;
            $logData['user_role'] = $user->role ?? 'unknown';
        }

        // Log dengan level warning untuk blocked access
        Log::warning('SECURITY: Access blocked by BlockPublicAccessMiddleware', $logData);
    }

    /**
     * Log akses yang berhasil (untuk debugging di development)
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return void
     */
    private function logSuccessfulAccess(Request $request, $user): void
    {
        $logData = [
            'middleware' => 'BlockPublicAccess',
            'action' => 'access_granted',
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'path' => $request->path(),
            'method' => $request->method(),
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::info('SECURITY: Admin access granted', $logData);
    }
}
