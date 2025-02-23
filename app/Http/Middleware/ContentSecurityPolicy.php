<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
    
        $cspPolicy = "default-src 'self';
            script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com http://127.0.0.1:5173; 
            style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://cdnjs.cloudflare.com https://fonts.googleapis.com; 
            img-src 'self' data: https://trusted-images.com; 
            font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net https://cdnjs.cloudflare.com; 
            connect-src 'self' https://api.trusted-source.com ws://127.0.0.1:5173 wss://127.0.0.1:5173; 
            frame-ancestors 'none'; object-src 'none'; form-action 'self';";
    
        // Replace accidental new lines in headers
        $cspPolicy = preg_replace('/\s+/', ' ', $cspPolicy);
    
        $response->headers->set('Content-Security-Policy', $cspPolicy);
        return $response;
    }    
}
