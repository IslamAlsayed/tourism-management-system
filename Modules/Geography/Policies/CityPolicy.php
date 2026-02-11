<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\City;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any cities.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_cities');
    }

    /**
     * Determine whether the user can view the city.
     */
    public function view(User $user, City $city): bool
    {
        return $user->can('manage_cities');
    }

    /**
     * Determine whether the user can create cities.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_cities');
    }

    /**
     * Determine whether the user can update the city.
     */
    public function update(User $user, City $city): bool
    {
        return $user->can('manage_cities');
    }

    /**
     * Determine whether the user can delete the city.
     */
    public function delete(User $user, City $city): bool
    {
        return $user->can('manage_cities');
    }

    /**
     * Determine whether the user can restore the city.
     */
    public function restore(User $user, City $city): bool
    {
        return $user->can('manage_cities');
    }

    /**
     * Determine whether the user can permanently delete the city.
     */
    public function forceDelete(User $user, City $city): bool
    {
        return $user->can('superadmin');
    }
}
