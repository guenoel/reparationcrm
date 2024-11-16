<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Worker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect('login');
        }

        $user_role = Auth::user()->role;
        
        if($user_role == '1'){
            return $next($request);
        }

        if($user_role == '2'){
            return redirect()->route('dashboard_admin');
        }

        if($user_role == '0'){
            return redirect()->route('dashboard');
        }
        return redirect('/');
    }
}
