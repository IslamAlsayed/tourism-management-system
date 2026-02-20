<?php

namespace Modules\Geography\Database\Seeders;

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
            'manage_currencies',
            'manage_regions',
            'manage_subregions',
            'manage_countries',
            'manage_states',
            'manage_cities',
            'manage_nationalities',
            'view_currencies',
            'view_regions',
            'view_subregions',
            'view_countries',
            'view_states',
            'view_cities',
            'view_nationalities',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign All Permissions to Superadmin
        $superadminRole->syncPermissions(Permission::all());

        // Assign Admin Permissions (all except system management)
        $adminPermissions = Permission::whereIn('name', [
            'manage_currencies',
            'manage_regions',
            'manage_subregions',
            'manage_countries',
            'manage_states',
            'manage_cities',
            'manage_nationalities',
        ])->get();
        $adminRole->syncPermissions($adminPermissions);

        // Assign User Permissions (view only)
        $userPermissions = Permission::whereIn('name', [
            'view_currencies',
            'view_regions',
            'view_subregions',
            'view_countries',
            'view_states',
            'view_cities',
            'view_nationalities',
        ])->get();
        $userRole->syncPermissions($userPermissions);
    }
}
