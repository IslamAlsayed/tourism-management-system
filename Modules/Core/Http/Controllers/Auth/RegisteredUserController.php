<?php

namespace Modules\Core\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Modules\Core\Entities\User;
use Modules\Geography\Entities\Country;
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
        $countries = Country::all();
        return view('core::auth.register', compact('countries'));
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
            'country_id' => ['required', 'exists:countries,id'],
            'mobile' => ['required', 'string', 'max:20'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_website' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_id' => $request->country_id,
            'mobile' => $request->mobile,
            'company_name' => $request->company_name,
            'company_website' => $request->company_website,
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
