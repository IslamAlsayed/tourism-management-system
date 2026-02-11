<?php

namespace Modules\Core\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Modules\Core\Entities\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('core::auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        activity()->causedBy($user)->performedOn($user)->useLog('models')->event('register')->withProperties([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'registration_time' => now()->toDateTimeString(),
        ])->log('New user registered');
        Auth::login($user);
        return redirect(route('dashboard', false))->withSuccess(__('messages.welcome_back_name', ['name' => Auth::user()->name ?? 'User']));
    }
}