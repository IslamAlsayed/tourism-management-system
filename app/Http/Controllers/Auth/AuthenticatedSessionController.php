<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Events\UserLoggedEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        if (session('login_attempted')) {
            return view('auth.login');
        }
        // Only show 'please_login_to_continue' on first visit, not every time
        if (!session('login_attempted')) {
            session(['login_attempted' => true]);
            showToastInfoMessage(__('messages.please_login_to_continue'));
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = getActiveUser();
        if ($user) {
            event(new UserLoggedEvent($user, 'online'));
            activity()->causedBy($user)->performedOn($user)->useLog('models')->event('login')->withProperties([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'login_time' => now()->toDateTimeString(),
            ])->log(__('messages.user_logged_in', ['name' => $user->name]));
        }
        showToastSuccessMessage(__('messages.welcome_back_name', ['name' => Auth::user()->name ?? 'User']));
        return redirect()->intended(route('dashboard', false));
    }

    /**
     * Destroy an authenticated session.
     */
    public static function destroy(Request $request)
    {
        $user = getActiveUser();
        if ($user) {
            event(new UserLoggedEvent($user, 'offline'));
            activity()->causedBy($user)->performedOn($user)->useLog('models')->event('logout')->withProperties([
                'ip_address' => $request->ip(),
                'logout_time' => now()->toDateTimeString(),
                'expired' => true
            ])->log(__('messages.user_logged_out', ['name' => $user->name]));
        }
        event(new UserLoggedEvent($user, 'offline'));
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        showToastSuccessMessage(__('messages.goodbye_name', ['name' => $user->name ?? 'User']));
        return redirect('/');
    }

    public function expired()
    {
        if (session('session_expired')) {
            session()->forget(['login_attempted']);
            showToastWarningMessage(__('messages.session_expired'))->pin();
            return view('auth.login');
        }
        return redirect('/login');
    }
}