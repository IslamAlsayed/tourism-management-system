<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\CityState;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityStatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any cityStates.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_city_states');
    }

    /**
     * Determine whether the user can view the cityState.
     */
    public function view(User $user, CityState $cityState): bool
    {
        return $user->can('manage_city_states');
    }

    /**
     * Determine whether the user can create cityStates.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_city_states');
    }

    /**
     * Determine whether the user can update the cityState.
     */
    public function update(User $user, CityState $cityState): bool
    {
        return $user->can('manage_city_states');
    }

    /**
     * Determine whether the user can delete the cityState.
     */
    public function delete(User $user, CityState $cityState): bool
    {
        return $user->can('manage_city_states');
    }

    /**
     * Determine whether the user can restore the cityState.
     */
    public function restore(User $user, CityState $cityState): bool
    {
        return $user->can('manage_city_states');
    }

    /**
     * Determine whether the user can permanently delete the cityState.
     */
    public function forceDelete(User $user, CityState $cityState): bool
    {
        return $user->can('superadmin');
    }
}
