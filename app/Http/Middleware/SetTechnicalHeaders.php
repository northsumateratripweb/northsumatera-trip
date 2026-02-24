<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTechnicalHeaders
{
    /**
     * Add technical SEO and performance headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Cache Control for static pages (HTML responses)
        if ($response->headers->get('Content-Type') && str_contains($response->headers->get('Content-Type'), 'text/html')) {
            // Public pages: cache for 5 minutes, revalidate after
            if (!$request->is('admin/*', 'login', 'register', 'profile*', 'dashboard*', 'checkout*')) {
                $response->headers->set('Cache-Control', 'public, max-age=300, s-maxage=600, stale-while-revalidate=86400');
            } else {
                // Private pages: no cache
                $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
                $response->headers->set('Pragma', 'no-cache');
            }
        }

        // Vary header for proper caching with language & encoding
        $response->headers->set('Vary', 'Accept-Encoding, Accept-Language');

        // X-Robots-Tag for non-crawlable pages
        if ($request->is('admin/*', 'login', 'register', 'password/*', 'profile*', 'dashboard*')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        } else {
            $response->headers->set('X-Robots-Tag', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1');
        }

        // DNS Prefetch Control
        $response->headers->set('X-DNS-Prefetch-Control', 'on');

        return $response;
    }
}
