<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\VisaRequirement;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VisaRequirementSeeder extends Seeder
{
    public function run()
    {
        truncateWithReset(VisaRequirement::class);
        RichText::where('record_type', VisaRequirement::class)->delete();

        $permissions = [
            'create_visa_requirements',
            'edit_visa_requirements',
            'delete_visa_requirements',
            'view_visa_requirements',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole       = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Superadmin → everything
        $superadminRole->syncPermissions(Permission::all());

        // Admin → jeep permissions
        $adminPermissions = Permission::whereIn('name', $permissions)->get();
        $adminRole->syncPermissions($adminPermissions);

        // User → view only
        $userRole->syncPermissions(Permission::where('name', 'view_jeeps')->get());
    }
}
