<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        showToastSuccessMessage(__('main.messages.welcome_back_name', ['name' => Auth::user()->name ?? 'User']));
        return redirect()->intended(route('dashboard', false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        showToastSuccessMessage(__('main.messages.goodbye_name', ['name' => Auth::user()->name ?? 'User']));
        return redirect('/');
    }
}