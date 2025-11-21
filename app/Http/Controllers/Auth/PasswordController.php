<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        $user = $request->user();
        $user->update(['password' => Hash::make($validated['password'])]);
        activity()->causedBy($user)->performedOn($user)->useLog('models')->event('password_update')->withProperties([
            'ip_address' => $request->ip(),
            'update_time' => now()->toDateTimeString(),
        ])->log('Password has been updated');
        return back()->with('status', 'password-updated');
    }
}