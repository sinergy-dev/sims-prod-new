<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // ... (other headers like HSTS, X-Frame-Options, X-Content-Type-Options) ...
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://maps.googleapis.com https://cdn.dhtmlx.com https://export.dhtmlx.com https://cdn.datatables.net https://code.jquery.com https://rawgit.com https://cdn.jsdelivr.net",
            "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://maps.googleapis.com https://fonts.googleapis.com https://cdn.dhtmlx.com https://www.mycustomer.com https://cdn.jsdelivr.net",
            "img-src 'self' data: https://maps.googleapis.com https://*.gstatic.com https://*.googleusercontent.com http://*.googleusercontent.com https://drive.google.com",
            "font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com data:",
            "object-src 'none'",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "base-uri 'self'",
            "connect-src 'self' https://maps.googleapis.com https://www.googleapis.com",
        ];
        $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        return $response;
    }
}
