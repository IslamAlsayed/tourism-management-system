<?php

namespace Modules\Localization\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $permissions = [
            'manage_languages',
            'manage_system_languages',
            'manage_currencies',
            'manage_timezones',
            'view_languages',
            'view_system_languages',
            'view_currencies',
            'view_timezones',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign All Permissions to Superadmin
        $superadminRole->syncPermissions(Permission::all());

        // Assign Admin Permissions (all except system management)
        $adminPermissions = Permission::whereIn('name', [
            'manage_languages',
            'manage_currencies',
            'manage_timezones',
        ])->get();
        $adminRole->syncPermissions($adminPermissions);

        // Assign User Permissions (view only)
        $userPermissions = Permission::whereIn('name', [
            'view_languages',
            'view_currencies',
            'view_timezones',
        ])->get();
        $userRole->syncPermissions($userPermissions);
    }
}
