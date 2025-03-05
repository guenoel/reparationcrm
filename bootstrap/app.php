<?php
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleBasedAccessControl;
use App\Http\Middleware\ContentSecurityPolicy;
use Barryvdh\DomPDF\ServiceProvider;
use Barryvdh\DomPDF\Facade\Pdf;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->web(prepend: [
        //     ContentSecurityPolicy::class, // Add CSP middleware
        // ]);

        // $middleware->web(prepend: [
        //     \Spatie\Csp\AddCspHeaders::class, // Ensure CSP Middleware is registered
        // ]);

        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            //\Spatie\Csp\AddCspHeaders::class,
            //\App\Http\Middleware\ClickjackingProtection::class,
        ]);

        // Sanctum middleware for APIs
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'role-based-access-control' => RoleBasedAccessControl::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        ServiceProvider::class, // Ajoute DomPDF au système de providers
        App\Providers\PdfServiceProvider::class, // Ajoute l'alias PDF
    ])
    ->create();
