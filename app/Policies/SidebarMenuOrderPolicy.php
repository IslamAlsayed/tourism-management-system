<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use App\Models\SidebarMenuOrder;

class SidebarMenuOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->hasRole('superadmin');
    }
}
