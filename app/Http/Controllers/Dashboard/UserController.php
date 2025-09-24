<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Country;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.users.index');
    }

    public function create()
    {
        $countries = Country::all();
        return view('pages.dashboard.users.create', compact('countries'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.dashboard.users.show', compact('user'));
    }

    public function store(UserCreateRequest $request)
    {
        $validated = $request->validated();
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        $user = User::create($validated);

        if ($user) {
            $this->uploadPhoto($request, $user, 'avatar_url', "profile-photos");
            return redirect()->route('users.index')->with('success', __('main.messages.user_created'));
        }

        return redirect()->route('users.index')->with('error', __('main.messages.user_creation_failed'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $countries = Country::all();
        return view('pages.dashboard.users.edit', compact('user', 'countries'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        $validated['name'] = ($validated['first_name'] ?? $user->first_name) . ' ' . ($validated['last_name'] ?? $user->last_name);

        $this->uploadPhoto($request, $user, 'avatar_url', "profile-photos");

        $user->update($validated);

        return redirect()->route('users.index')->with('success', __('main.messages.user_updated'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $deleted = $user->delete();
        if ($deleted) {
            $this->deletePhoto($user, 'avatar_url');
            return redirect()->route('users.index')->with('success', __('main.messages.user_deleted'));
        }

        return redirect()->route('users.index')->with('error', __('main.messages.user_deletion_failed'));
    }
}