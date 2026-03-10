<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        truncateWithReset(Role::class);
        truncateWithReset(Permission::class);

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create Roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Define Permissions
        $permissions = [
            // User Management
            'manage_users',
            'view_users',

            // Roles & Permissions
            'manage_roles',
            'manage_permissions',

            // System Settings
            'manage_system',
            'manage_settings',

            // Dashboard
            'view_dashboard',

            // Data Management (general)
            'manage_data',
            'view_data',

            // Specific Data Management
            'manage_clients',
            'manage_currencies',
            'manage_regions',
            'manage_subregions',
            'manage_countries',
            'manage_states',
            'manage_cities',
            'manage_airlines',
            'manage_accommodations',
            'manage_restaurants',
            'manage_tours',
            'manage_tour_guides',
            'manage_meals',
            'manage_rooms',
            'manage_media',

            // Import/Export
            'import_data',
            'export_data',

            // Reports
            'view_reports',
            'export_reports',

            // Activity
            'view_activity_log',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign All Permissions to Superadmin
        $superadminRole->syncPermissions(Permission::all());

        // Assign Admin Permissions (all except system management)
        $adminPermissions = array_filter($permissions, function ($permission) {
            return !in_array($permission, ['manage_roles', 'manage_system']);
        });
        $adminRole->syncPermissions($adminPermissions);

        // Assign User Permissions (view and create data only)
        $userPermissions = [
            'view_dashboard',
            'view_users',
            'view_data',
            'export_reports',
            'view_activity_log',
        ];
        $userRole->syncPermissions($userPermissions);
    }
}
