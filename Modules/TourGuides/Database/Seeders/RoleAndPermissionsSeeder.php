<?php

namespace Modules\TourGuides\Database\Seeders;

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
            'manage_tour_guides',
            'manage_tour_guide_types',
            'manage_tour_guides_reviews',
            'view_tour_guides',
            'view_tour_guide_types',
            'view_tour_guides_reviews',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign All Permissions to Superadmin
        $superadminRole->syncPermissions(Permission::all());

        // Assign Admin Permissions (all except system management)
        $adminPermissions = Permission::whereIn('name', [
            'manage_tour_guides',
            'manage_tour_guide_types',
            'manage_tour_guides_reviews',
        ])->get();
        $adminRole->syncPermissions($adminPermissions);

        // Assign User Permissions (view only)
        $userPermissions = Permission::whereIn('name', [
            'view_tour_guides',
            'view_tour_guide_types',
            'view_tour_guides_reviews',
        ])->get();
        $userRole->syncPermissions($userPermissions);
    }
}
