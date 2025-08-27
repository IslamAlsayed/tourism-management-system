<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        $totalUsers = User::count();
        return view('pages.dashboard.users.index', compact('users', 'totalUsers'));
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

        if ($request->hasFile('photo')) {
            $filename = $request->file('photo')->hashName();
            $path = $request->file('photo')->storeAs("profile-photos/{$user->id}", $filename, 'public');
            $user->update(['avatar_url' => $path]);
        }

        return redirect()->route('users.index')->with('success', __('main.messages.user_created'));
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

        if ($request->hasFile('photo')) {
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            $filename = $request->file('photo')->hashName();
            $path = $request->file('photo')->storeAs("profile-photos/{$user->id}", $filename, 'public');
            $validated['avatar_url'] = $path;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', __('main.messages.user_updated'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $deleted = $user->delete();
        if ($deleted) {
            return redirect()->route('users.index')->with('success', __('main.messages.user_deleted'));
        }

        return redirect()->route('users.index')->with('error', __('main.messages.user_deletion_failed'));
    }
}