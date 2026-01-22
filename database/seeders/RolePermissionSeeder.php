<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create Roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Define Permissions
        $permissions = [
            // User Management
            'create_users',
            'edit_users',
            'delete_users',
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
            'create_data',
            'edit_data',
            'delete_data',
            'view_data',

            // Specific Data Management
            'manage_countries',
            'manage_cities',
            'manage_currencies',
            'manage_airlines',
            'manage_accommodations',
            'manage_restaurants',
            'manage_clients',
            'manage_tours',
            'manage_tour_guides',
            'manage_meals',
            'manage_rooms',
            'manage_media',
            'manage_settings',

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
