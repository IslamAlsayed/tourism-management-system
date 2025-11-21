<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
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
    public function create(): View
    {
        if (session('login_attempted')) {
            return view('auth.login');
        }
        session(['login_attempted' => true]);
        showToastInfoMessage(__('main.messages.please_login_to_continue'));
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();
        event(new UserLoggedEvent($user, 'online'));
        \Illuminate\Support\Facades\Log::info('User logged in', ['user_name' => $user->name, 'user_status' => $user->user_status]);
        showToastSuccessMessage(__('main.messages.welcome_back_name', ['name' => Auth::user()->name ?? 'User']));
        return redirect()->intended(route('dashboard', false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        event(new UserLoggedEvent(Auth::user(), 'offline'));
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        showToastSuccessMessage(__('main.messages.goodbye_name', ['name' => Auth::user()->name ?? 'User']));
        return redirect('/');
    }
}