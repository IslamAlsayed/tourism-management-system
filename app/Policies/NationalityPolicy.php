<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Modules\Core\Entities\User;
use Modules\Geography\Entities\Nationality;

class NationalityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_nationalities');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Nationality $nationality): bool
    {
        return $user->can('manage_nationalities');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_nationalities');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Nationality $nationality): bool
    {
        return $user->can('manage_nationalities');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Nationality $nationality): bool
    {
        return $user->can('manage_nationalities');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Nationality $nationality): bool
    {
        return $user->can('manage_nationalities');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Nationality $nationality): bool
    {
        return $user->hasRole('superadmin');
    }
}
