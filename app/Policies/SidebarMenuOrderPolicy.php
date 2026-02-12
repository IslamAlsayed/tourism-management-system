<?php

namespace App\Policies;

use App\Models\SidebarMenuOrder;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;

class SidebarMenuOrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_sidebar_menu_orders');
    }

    public function view(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->can('manage_sidebar_menu_orders');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_sidebar_menu_orders');
    }

    public function update(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->can('manage_sidebar_menu_orders');
    }

    public function delete(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->can('manage_sidebar_menu_orders');
    }

    public function restore(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->can('manage_sidebar_menu_orders');
    }

    public function forceDelete(User $user, SidebarMenuOrder $sidebarMenuOrder): bool
    {
        return $user->hasRole('superadmin');
    }
}
