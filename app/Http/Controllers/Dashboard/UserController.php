<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        $totalUsers = User::count();
        $statusOptions = ['Active', 'Inactive'];
        return view('pages.dashboard.users.index', compact('users', 'totalUsers', 'statusOptions'));
    }

    public function create()
    {
        $countries = Country::orderBy('name_ar')->get();
        return view('pages.dashboard.users.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'nullable|string|max:255|unique:users,username',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'country_id' => 'nullable|exists:countries,id',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,moderator,user',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'email_verified' => 'boolean',
            'notifications_enabled' => 'boolean',
            'marketing_emails' => 'boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Combine first and last name
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Handle checkboxes
        $validated['is_active'] = $request->has('is_active');
        $validated['email_verified_at'] = $request->has('email_verified') ? now() : null;
        $validated['notifications_enabled'] = $request->has('notifications_enabled');
        $validated['marketing_emails'] = $request->has('marketing_emails');

        User::create($validated);

        if ($request->has('save_and_add')) {
            return redirect()->route('users.create')->with('success', 'تم إنشاء المستخدم بنجاح! يمكنك إضافة مستخدم آخر.');
        }

        return redirect()->route('users.index')->with('success', 'تم إنشاء المستخدم بنجاح!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $updated = $user->update($validated);
        if ($updated) {
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }

        return redirect()->route('users.index')->with('error', 'User update failed');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $deleted = $user->delete();
        if ($deleted) {
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        }

        return redirect()->route('users.index')->with('error', 'User deletion failed');
    }
}
