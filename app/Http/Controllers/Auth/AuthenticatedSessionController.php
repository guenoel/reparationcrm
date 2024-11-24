<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $role = $request->user()->role;

    Log::info("AuthenticatedSessionController role user: $role");
    Log::info("Assertion role user 1: " . ($role == '1'));

    $redirectRoute = match ($role) {
        2 => 'dashboard_admin',  // Named route for admin
        1 => 'dashboard_worker', // Named route for worker
        0 => 'dashboard',        // Named route for customer
        default => Log::info("Default case executed for role: $role") && 'welcome',      // Fallback named route
    };

    Log::info("Redirecting to route: $redirectRoute");

    return redirect()->route($redirectRoute);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
