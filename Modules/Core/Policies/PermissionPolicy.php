<?php

namespace Modules\Core\Policies;

use Modules\Core\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_permissions');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->can('manage_permissions');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_permissions');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->can('manage_permissions');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->can('manage_permissions');
    }

    public function restore(User $user, Permission $permission): bool
    {
        return $user->can('manage_permissions');
    }

    public function forceDelete(User $user, Permission $permission): bool
    {
        return $user->hasRole('superadmin');
    }
}
