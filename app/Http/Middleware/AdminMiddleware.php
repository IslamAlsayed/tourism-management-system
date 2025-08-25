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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // For development/testing purposes, allow all authenticated users
        // You can customize this logic based on your user role system later
        return $next($request);

        /*
        // Uncomment and customize this section when you have a proper role system:
        $user = Auth::user();

        // Check if user has admin privileges
        if ($user->email === 'admin@example.com' ||
            (isset($user->is_admin) && $user->is_admin) ||
            (isset($user->role) && $user->role === 'admin')) {
            return $next($request);
        }

        // If not admin, redirect with error
        abort(403, 'Access denied. Administrator privileges required.');
        */
    }
}
