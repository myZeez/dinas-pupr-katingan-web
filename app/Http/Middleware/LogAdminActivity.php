<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogAdminActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log for authenticated admin users
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            // Add debug log
            Log::info('LogAdminActivity: Attempting to log for user', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role,
                'route' => $request->route()?->getName(),
                'method' => $request->method(),
                'url' => $request->url()
            ]);

            $this->logActivity($request, $response);
        }

        return $response;
    }

    private function logActivity(Request $request, Response $response)
    {
        // Skip logging for certain routes
        $skipRoutes = [
            'admin.dashboard',
            'admin.activity-log.index',
            'admin.activity-log.show',
            'admin.activity-log.destroy',
            'admin.activity-log.clear',
            'admin.activity-log.cleanup',
            'logout'
        ];

        $routeName = $request->route()?->getName();

        if (in_array($routeName, $skipRoutes)) {
            Log::info('LogAdminActivity: Skipping route', ['route' => $routeName]);
            return;
        }

        // Determine action based on HTTP method and route
        $action = $this->determineAction($request);
        $description = $this->generateDescription($request, $action);

        // Skip if no meaningful action
        if (!$action || !$description) {
            Log::info('LogAdminActivity: Skipping - no action or description', [
                'action' => $action,
                'description' => $description,
                'route' => $routeName
            ]);
            return;
        }

        Log::info('LogAdminActivity: Creating activity log', [
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'route' => $routeName
        ]);

        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => $this->getModelType($request),
                'model_id' => $this->getModelId($request),
                'description' => $description,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'status_code' => $response->getStatusCode()
            ]);
            Log::info('LogAdminActivity: Activity log created successfully');
        } catch (\Exception $e) {
            Log::error('LogAdminActivity: Failed to create activity log', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function determineAction(Request $request): ?string
    {
        $method = $request->method();
        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return null;
        }

        // Map route patterns to actions
        if (str_contains($routeName, '.index') || str_contains($routeName, '.show')) {
            return 'view';
        }

        if (str_contains($routeName, '.create') || str_contains($routeName, '.store')) {
            return 'create';
        }

        if (str_contains($routeName, '.edit') || str_contains($routeName, '.update')) {
            return 'update';
        }

        if (str_contains($routeName, '.destroy') || str_contains($routeName, '.delete')) {
            return 'delete';
        }

        return strtolower($method);
    }

    private function generateDescription(Request $request, string $action): ?string
    {
        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return null;
        }

        $routeParts = explode('.', $routeName);
        $resource = ucfirst(str_replace('-', ' ', $routeParts[1] ?? 'resource'));

        $actionText = match ($action) {
            'view' => 'Melihat',
            'create' => 'Menambah',
            'update' => 'Mengubah',
            'delete' => 'Menghapus',
            default => ucfirst($action)
        };

        return $actionText . ' ' . $resource;
    }

    private function getModelType(Request $request): ?string
    {
        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return null;
        }

        $routeParts = explode('.', $routeName);
        $resource = $routeParts[1] ?? null;

        // Map resource names to model classes
        $modelMap = [
            'berita' => 'App\\Models\\Berita',
            'layanan' => 'App\\Models\\Layanan',
            'pengaduan' => 'App\\Models\\Pengaduan',
            'struktur' => 'App\\Models\\Struktur',
            'galeri' => 'App\\Models\\Galeri',
            'file-download' => 'App\\Models\\FileDownload',
            'users' => 'App\\Models\\User'
        ];

        return $modelMap[$resource] ?? null;
    }

    private function getModelId(Request $request): ?int
    {
        $route = $request->route();

        if (!$route) {
            return null;
        }

        // Try to get ID from route parameters
        $parameters = $route->parameters();

        foreach ($parameters as $parameter) {
            if (is_object($parameter) && method_exists($parameter, 'getKey')) {
                return $parameter->getKey();
            }

            if (is_numeric($parameter)) {
                return (int) $parameter;
            }
        }

        return null;
    }
}
