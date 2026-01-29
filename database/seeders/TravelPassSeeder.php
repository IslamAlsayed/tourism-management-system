<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\TravelPass;
use App\Models\TravelPassSite;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TravelPassSeeder extends Seeder
{
    public function run()
    {
        truncateWithReset(TravelPass::class);
        truncateWithReset(TravelPassSite::class);
        RichText::where('record_type', TravelPass::class)->delete();

        $permissions = [
            'create_travel_pass',
            'edit_travel_pass',
            'delete_travel_pass',
            'view_travel_pass',
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
        $userRole->syncPermissions(Permission::where('name', 'view_travel_pass')->get());
    }
}
