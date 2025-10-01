<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlockLegacyAssets
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Block requests to legacy LOGO.png
        if ($request->is('img/LOGO.png') || str_contains($request->path(), 'LOGO.png')) {
            Log::info('🚫 Blocked legacy LOGO.png request', [
                'url' => $request->fullUrl(),
                'referer' => $request->header('referer'),
                'user_agent' => $request->header('user-agent'),
                'ip' => $request->ip(),
            ]);

            // Return 410 Gone (permanently removed)
            return response('This logo has been permanently removed. Please update your bookmarks.', 410)
                   ->header('Content-Type', 'text/plain')
                   ->header('Cache-Control', 'public, max-age=31536000'); // Cache for 1 year
        }

        return $next($request);
    }
}
