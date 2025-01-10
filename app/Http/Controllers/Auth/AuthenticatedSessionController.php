<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        Log::info('Session Regenerated:', $request->session()->all());

        $role = $request->user()->role;
        // Wrap $role in an array to pass it as context data
        Log::info('User Role:', ['role' => $role]);

        // Generate API token for the authenticated user
        $token = $request->user()->createToken('API Token')->plainTextToken;
        //Cookie::queue('Authorization', $token, 60, '/', config('session.domain'), config('session.secure_cookie'), false); // Expires in 60 minutes
        Cookie::queue('Authorization', $token, 60, '/', config('session.domain'), false, false);
        Log::info('Generated Token:', ['token' => $token]);

        $redirectRoute = match ($role) {
            2 => 'dashboard_admin',  // Named route for admin
            1 => 'dashboard_worker', // Named route for worker
            0 => 'dashboard',        // Named route for customer
            default => 'welcome',      // Fallback named route
        };

        return Inertia::render('Dashboard', [
            'message' => 'Logged in successfully',
            'token' => $token,
            'user' => $request->user(),
            'redirect_route' => route($redirectRoute),
        ]);
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
