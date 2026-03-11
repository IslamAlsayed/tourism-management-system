<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Modules\Core\Entities\User;
use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Http\Requests\ProfileUpdateRequest as UpdateRequest;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    use PhotoUploadTrait;
    /**
     * Show the application's profile dashboard.
     */
    public function index(Request $request): View
    {
        return view('core::profile.index', ['user' => getActiveUser()]);
    }

    /**
     * Show the user's public profile.
     */
    public function publicProfile(Request $request): View
    {
        return view('core::profile.profile-public', ['user' => getActiveUser()]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('core::profile.edit', [
            'user' => getActiveUser(),
            'countries' => \Modules\Geography\Entities\Country::all(),
        ]);
    }

    /**
     * Display the user's change password form.
     */
    public function changePassword(Request $request)
    {
        return view('core::profile.change-password', ['user' => getActiveUser()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        // Cache::tags(['users'])->flush();

        return redirect()->route('dashboard.core.profile.index')->withSuccess(__('messages.type_updated', ['type' => __('main.profile')]));
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = User::where('email', $request->user()->email)->first();
        if (!$user) {
            return redirect()->back()->withError(__('messages.user_not_found'));
        }
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required|confirmed|min:' . config('app.app_minimum_password_length'),
            'password_changed_at' => now(),
        ]);
        $user->fill($validated);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        if ($user->isDirty('password')) {
            $user->password_changed_at = now();
        }
        $updated = $user->save();
        if ($updated) {
            return redirect()->route('dashboard.core.profile.index')->withSuccess(__('messages.type_updated', ['type' => __('main.profile')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.profile')]));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
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
            'photo' => ['required', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);
        $user = $request->user();
        try {
            $this->uploadPhoto($request, $user, 'photo', 'profile-photos');
            // Cache::tags(['users'])->flush();
            return redirect()->route('dashboard.core.profile.index')->withSuccess(__('messages.photo_uploaded_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.core.profile.index')->withError(__('messages.no_photo_uploaded'));
        }
    }

    /**
     * Show the test settings page.
     */
    public function settingsTest()
    {
        $user = Auth::user();
        return view('core::profile.settings-test', compact('user'));
    }

    /**
     * Show the new professional settings page.
     */
    public function settingsNew()
    {
        $user = Auth::user();
        return view('core::profile.settings-test-new', compact('user'));
    }

    /**
     * Show the final professional settings page.
     */
    public function settingsFinal()
    {
        $user = Auth::user();
        return view('core::profile.settings-final', compact('user'));
    }

    /**
     * Show the security settings page.
     */
    public function security()
    {
        $user = Auth::user();
        return view('core::profile.security', compact('user'));
    }

    /**
     * Show the notifications settings page.
     */
    public function notifications()
    {
        $user = Auth::user();
        return view('core::profile.notifications', compact('user'));
    }
}
