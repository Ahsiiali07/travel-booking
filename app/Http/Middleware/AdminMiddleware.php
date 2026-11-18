<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in with administrator credentials.');
        }

        if (!Auth::user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Access denied. Administrator privileges required.');
        }

        if (Auth::user()->status === 'blocked') {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Your administrator account has been disabled.');
        }

        return $next($request);
    }
}
