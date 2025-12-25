<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Psy\Util\Str;

class SessionExpired
{
    public function handle(Request $request, Closure $next)
    {
        $loginTime = Session::get('login_time');
        $lifetime = config('session.lifetime') * 60;
        if ($loginTime && (time() - $loginTime > $lifetime)) {
            // Save the intended URL before logout
            $intendedUrl = $request->fullUrl();
            Session::forget(['login_time', 'login_attempted']);
            $user = getActiveUser();
            if ($user) {
                event(new \App\Events\UserLoggedEvent($user, 'offline'));
                activity()->causedBy($user)->performedOn($user)
                    ->useLog('models')->event('logout')
                    ->withProperties([
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'logout_time' => now()->toDateTimeString(),
                        'expired' => true
                    ])->log(__('messages.user_logged_out', ['name' => $user->name]));
            }
            Auth::logout();
            Session::put('session_expired', true);
            Session::put('url.intended', $intendedUrl);
            // Redirect with token in URL
            return redirect()->route('session.expired');
        }
        if (!$loginTime) {
            Session::put('login_time', time());
        }
        return $next($request);
    }
}