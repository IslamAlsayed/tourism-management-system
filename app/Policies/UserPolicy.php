<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the permission.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can create permissions.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can update the permission.
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can delete the permission.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can restore the permission.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the permission.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('superadmin');
    }
}
