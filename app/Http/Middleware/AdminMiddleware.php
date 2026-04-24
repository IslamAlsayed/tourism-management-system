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

        $user = Auth::user();

        // Check if user has admin privileges using the role field
        if (in_array($user->role, ['superadmin', 'admin'])) {
            return $next($request);
        }

        // TODO: Implement granular RBAC when additional roles are needed
        // For now, non-admin users are denied access to dashboard
        abort(403, __('messages.access_denied_admin_required', [
            'default' => 'Access denied. Administrator privileges required.'
        ]));
    }
}
