<?php

namespace Modules\Subscriptions\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $moduleKey): Response
    {
        /** @var \Modules\Core\Entities\User $user */
        $user = $request->user();

        // If user is not authenticated, let auth middleware handle it
        if (!$user) {
            return $next($request);
        }

        // Check if user has active subscription to the module
        if (!$user->hasActiveModule($moduleKey)) {
            abort(403, "You don't have an active subscription to the '{$moduleKey}' module. Please contact support to activate it.");
        }

        return $next($request);
    }
}
