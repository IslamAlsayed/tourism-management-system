<?php

namespace App\Policies;

use App\Models\Timezone;
use App\Models\User;

class TimezonePolicy
{
    /**
     * Determine whether the user can view the permission.
     */
    public function view(User $user, Timezone $timezone): bool
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
    public function update(User $user, Timezone $timezone): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can delete the permission.
     */
    public function delete(User $user, Timezone $timezone): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can restore the permission.
     */
    public function restore(User $user, Timezone $timezone): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the permission.
     */
    public function forceDelete(User $user, Timezone $timezone): bool
    {
        return $user->hasRole('superadmin');
    }
}
