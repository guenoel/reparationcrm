<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleBasedAccessControl
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            Log::info('User is not authenticated. Redirecting to login.');
            return redirect('login');
        }

        $user_role = (int) Auth::user()->role; // Cast role to integer
        $route_name = $request->route()->getName();

        Log::info('Middleware invoked', [
            'user_role' => $user_role,
            'route_name' => $route_name,
        ]);

        // Redirect to the correct dashboard if accessing the wrong one
        if ($this->isDashboardRoute($route_name)) {
            $canAccessDashboard = $this->canAccessDashboard($user_role, $route_name);
            Log::info('Checking dashboard access', [
                'route_name' => $route_name,
                'can_access' => $canAccessDashboard,
            ]);

            if (!$canAccessDashboard) {
                $redirectRoute = $this->getDashboardRouteForRole($user_role);
                Log::info('Redirecting to correct dashboard', [
                    'redirect_to' => $redirectRoute,
                ]);
                return redirect()->route($redirectRoute);
            }
        }

        // Restrict access to other routes
        $canAccessRoute = $this->canAccessRoute($user_role, $route_name);
        Log::info('Checking general route access', [
            'route_name' => $route_name,
            'can_access' => $canAccessRoute,
        ]);

        if (!$canAccessRoute) {
            Log::warning('Unauthorized access attempt', [
                'user_role' => $user_role,
                'route_name' => $route_name,
            ]);
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }

    /**
     * Determines the correct dashboard route based on the user's role.
     */
    private function getDashboardRouteForRole(int $role): string
    {
        $dashboardRoute = match ($role) {
            2 => 'dashboard_admin',   // Admin
            1 => 'dashboard_worker',  // Worker
            0 => 'dashboard',         // Customer
            default => '/',
        };

        Log::info('Resolved dashboard route', [
            'role' => $role,
            'dashboard_route' => $dashboardRoute,
        ]);

        return $dashboardRoute;
    }

    /**
     * Checks if the current route is a dashboard route.
     */
    private function isDashboardRoute(string $route_name): bool
    {
        $isDashboardRoute = in_array($route_name, ['dashboard_admin', 'dashboard_worker', 'dashboard']);
        Log::info('Checking if route is dashboard route', [
            'route_name' => $route_name,
            'is_dashboard_route' => $isDashboardRoute,
        ]);
        return $isDashboardRoute;
    }

    /**
     * Determines if a user can access the current dashboard route.
     */
    private function canAccessDashboard(int $role, string $route_name): bool
    {
        $canAccess = match ($route_name) {
            'dashboard_admin' => $role === 2,  // Only admin
            'dashboard_worker' => $role === 1, // Only worker
            'dashboard' => $role === 0,        // Only customer
            default => false,
        };

        Log::info('Checking dashboard access', [
            'route_name' => $route_name,
            'role' => $role,
            'can_access' => $canAccess,
        ]);

        return $canAccess;
    }

    /**
     * Determines if a user can access a specific route based on their role.
     */
    private function canAccessRoute(int $role, string $route_name): bool
    {
        $canAccess = match ($route_name) {
            // Accessible only to Admins (role >= 2)
            'dashboard_admin', 'users.index', 'spare_types.index', 'users.edit', 'spare_types.edit' => $role >= 2,

            // Accessible to Workers and Admins (role >= 1)
            'dashboard_worker', 'tasks.index', 'tasks.create', 'tasks.edit', 'spares.index', 'spares.create', 'spares.edit' => $role >= 1,

            // Accessible only to Customers (role == 0)
            'dashboard', 'devices.index', 'devices.create', 'devices.edit',
            'services.index', 'services.create', 'services.edit' => $role >= 0,

            // Default: Deny access
            default => false,
        };

        Log::info('Checking route access', [
            'route_name' => $route_name,
            'role' => $role,
            'can_access' => $canAccess,
        ]);

        return $canAccess;
    }
}