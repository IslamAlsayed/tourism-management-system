<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\Country;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any countries.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_countries');
    }

    /**
     * Determine whether the user can view the country.
     */
    public function view(User $user, Country $country): bool
    {
        return $user->can('manage_countries');
    }

    /**
     * Determine whether the user can create countries.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_countries');
    }

    /**
     * Determine whether the user can update the country.
     */
    public function update(User $user, Country $country): bool
    {
        return $user->can('manage_countries');
    }

    /**
     * Determine whether the user can delete the country.
     */
    public function delete(User $user, Country $country): bool
    {
        return $user->can('manage_countries');
    }

    /**
     * Determine whether the user can restore the country.
     */
    public function restore(User $user, Country $country): bool
    {
        return $user->can('manage_countries');
    }

    /**
     * Determine whether the user can permanently delete the country.
     */
    public function forceDelete(User $user, Country $country): bool
    {
        return $user->can('superadmin');
    }
}
