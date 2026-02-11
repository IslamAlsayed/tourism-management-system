<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\Region;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any regions.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_regions');
    }

    /**
     * Determine whether the user can view the region.
     */
    public function view(User $user, Region $region): bool
    {
        return $user->can('manage_regions');
    }

    /**
     * Determine whether the user can create regions.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_regions');
    }

    /**
     * Determine whether the user can update the region.
     */
    public function update(User $user, Region $region): bool
    {
        return $user->can('manage_regions');
    }

    /**
     * Determine whether the user can delete the region.
     */
    public function delete(User $user, Region $region): bool
    {
        return $user->can('manage_regions');
    }

    /**
     * Determine whether the user can restore the region.
     */
    public function restore(User $user, Region $region): bool
    {
        return $user->can('manage_regions');
    }

    /**
     * Determine whether the user can permanently delete the region.
     */
    public function forceDelete(User $user, Region $region): bool
    {
        return $user->can('superadmin');
    }
}
