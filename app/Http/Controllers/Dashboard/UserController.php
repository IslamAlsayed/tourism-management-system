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
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.user')]));
        }
        return view('pages.dashboard.users.show', compact('user'));
    }

    public function store(UserCreateRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->safe()->except('photo');
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        $created = User::create($validated);

        if ($created) {
            $this->uploadPhoto($request, $created, 'photo', "users");
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.user')]));
            }
            return redirect()->route('users.index')->with('success', __('main.messages.type_created', ['type' => __('main.user')]));
        }

        return redirect()->route('users.index')->with('error', __('main.messages.type_created', ['type' => __('main.user')]));
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.user')]));
        }
        $countries = Country::all();
        return view('pages.dashboard.users.edit', compact('user', 'countries'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.user')]));
        }
        $validated = $request->validated();
        $validated = $request->safe()->except('photo');

        $validated['name'] = ($validated['first_name'] ?? $user->first_name) . ' ' . ($validated['last_name'] ?? $user->last_name);

        $this->uploadPhoto($request, $user, 'photo', "users");

        $updated = $user->update($validated);

        if ($updated) {
            return redirect()->route('users.index')->with('success', __('main.messages.type_created', ['type' => __('main.user')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_creation_failed', ['type' => __('main.user')]));
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.user')]));
        }
        $deleted = $user->delete();
        if ($deleted) {
            $this->deletePhoto($user, 'photo');
            return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.user')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_created', ['type' => __('main.user')]));
    }
}