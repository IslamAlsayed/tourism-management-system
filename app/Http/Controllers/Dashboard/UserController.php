<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        $totalUsers = User::count();
        $statusOptions = ['Active', 'Inactive'];
        return view('pages.dashboard.users.index', compact('users', 'totalUsers', 'statusOptions'));
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