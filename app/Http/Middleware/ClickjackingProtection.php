<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClickjackingProtection
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Protect against Clickjacking
        $response->headers->set('X-Frame-Options', 'DENY'); // Prevents all iframes
        // Alternative option: $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // Allows only from the same origin
        
        // Add Content-Security-Policy for modern browsers
        $cspPolicy = "default-src 'self';
                      frame-ancestors 'none';"; // 'none' blocks all embedding in iframes

        return $response;
    }
}
