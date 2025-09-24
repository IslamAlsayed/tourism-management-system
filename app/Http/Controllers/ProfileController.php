<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserUpdateRequest;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use PhotoUploadTrait;
    /**
     * Show the application's profile dashboard.
     */
    public function index(Request $request): View
    {
        return view('pages.profile.index', ['user' => getActiveUser()]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('pages.profile.edit', ['user' => getActiveUser()]);
    }

    /**
     * Display the user's change password form.
     */
    public function changePassword(Request $request): View
    {
        return view('pages.profile.change-password', ['user' => getActiveUser()]);
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

        return redirect()->route('user.profile')->with('success', __('main.messages.profile_updated'));
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
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        try {
            $this->uploadPhoto($request, $user, 'avatar_url', 'profile-photos');
            return redirect()->route('user.profile')->with('success', __('main.messages.photo_uploaded_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('user.profile')->with('error', __('main.messages.no_photo_uploaded'));
        }
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