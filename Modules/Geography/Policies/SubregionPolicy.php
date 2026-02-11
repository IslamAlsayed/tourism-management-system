<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\Subregion;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubregionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any subregions.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_subregions');
    }

    /**
     * Determine whether the user can view the subregion.
     */
    public function view(User $user, Subregion $subregion): bool
    {
        return $user->can('manage_subregions');
    }

    /**
     * Determine whether the user can create subregions.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_subregions');
    }

    /**
     * Determine whether the user can update the subregion.
     */
    public function update(User $user, Subregion $subregion): bool
    {
        return $user->can('manage_subregions');
    }

    /**
     * Determine whether the user can delete the subregion.
     */
    public function delete(User $user, Subregion $subregion): bool
    {
        return $user->can('manage_subregions');
    }

    /**
     * Determine whether the user can restore the subregion.
     */
    public function restore(User $user, Subregion $subregion): bool
    {
        return $user->can('manage_subregions');
    }

    /**
     * Determine whether the user can permanently delete the subregion.
     */
    public function forceDelete(User $user, Subregion $subregion): bool
    {
        return $user->can('superadmin');
    }
}
