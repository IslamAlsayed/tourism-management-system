<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        return view('core::roles.index');
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('core::roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Role::class);
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return $role
            ? redirect()->route('dashboard.core.roles.index')->withSuccess(__('messages.role_created_successfully'))
            : redirect()->back()->withError(__('messages.role_creation_failed'));
    }

    public function show(Role $role)
    {
        $this->authorize('view', $role);
        $rolePermissions = $role->permissions->pluck('name');
        $allPermissions = Permission::all();
        return view('core::roles.show', compact('role', 'rolePermissions', 'allPermissions'));
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('core::roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $validated['name']]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        } else {
            $role->syncPermissions([]);
        }

        return $role
            ? redirect()->route('dashboard.core.roles.index')->withSuccess(__('messages.role_updated_successfully'))
            : redirect()->back()->withError(__('messages.role_update_failed'));
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        if (in_array($role->name, ['superadmin', 'admin', 'user'])) {
            return redirect()->back()->withError(__('messages.cannot_delete_default_role'));
        }

        $deleted = $role->delete();
        return $deleted
            ? redirect()->route('dashboard.core.roles.index')->withSuccess(__('messages.role_deleted_successfully'))
            : redirect()->back()->withError(__('messages.role_deletion_failed'));
    }
}
