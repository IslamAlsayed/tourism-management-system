<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the application's profile dashboard.
     */
    public function index(Request $request): View
    {
        return view('pages.profile.index2', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UserUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = $request->user();
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:1024'],
        ]);

        $user = $request->user();

        if ($request->hasFile('photo')) {
            if ($user->avatar_url) {
                // Delete the old photo
                Storage::disk('public')->delete($user->avatar_url);
            }

            // Store the new photo
            $filename = $request->file('photo')->hashName();
            $path = $request->file('photo')->storeAs('profile-photos' . '/' . $user->id, $filename, 'public');
            $user->avatar_url = $path;
            $user->save();
            return redirect()->route('user.profile')->with('success', 'Profile photo updated successfully.');
        }

        return redirect()->route('user.profile')->with('error', 'No photo uploaded.');
    }

    /**
     * Show the test settings page.
     */
    public function settingsTest()
    {
        $user = Auth::user();
        return view('pages.profile.settings-test', compact('user'));
    }

    /**
     * Show the new professional settings page.
     */
    public function settingsNew()
    {
        $user = Auth::user();
        return view('pages.profile.settings-test-new', compact('user'));
    }

    /**
     * Show the final professional settings page.
     */
    public function settingsFinal()
    {
        $user = Auth::user();
        return view('pages.profile.settings-final', compact('user'));
    }
}
