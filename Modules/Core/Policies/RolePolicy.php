<?php

namespace Modules\Core\Policies;

use Modules\Core\Entities\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_roles');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('manage_roles');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_roles');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('manage_roles');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('manage_roles');
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->can('manage_roles');
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return $user->hasRole('superadmin');
    }
}
