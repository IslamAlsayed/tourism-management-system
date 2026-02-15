<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(getPaginate());
        return view('core::permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('core::permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|unique:permissions,name']);
        $created =  Permission::create(['name' => $validated['name'], 'guard_name' => 'web']);
        return $created
            ? redirect()->route('dashboard.core.permissions.index')->withSuccess(__('messages.permission_created_successfully'))
            : redirect()->back()->withError(__('messages.permission_creation_failed'));
    }

    public function show(Permission $permission)
    {
        return view('core::permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('core::permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate(['name' => 'required|string|unique:permissions,name,' . $permission->id]);
        $updated = $permission->update(['name' => $validated['name']]);
        return $updated
            ? redirect()->route('dashboard.core.permissions.index')->withSuccess(__('messages.permission_updated_successfully'))
            : redirect()->back()->withError(__('messages.permission_update_failed'));
    }

    public function destroy(Permission $permission)
    {
        $deleted = $permission->delete();
        return $deleted
            ? redirect()->route('dashboard.core.permissions.index')->withSuccess(__('messages.permission_deleted_successfully'))
            : redirect()->back()->withError(__('messages.permission_deletion_failed'));
    }
}
