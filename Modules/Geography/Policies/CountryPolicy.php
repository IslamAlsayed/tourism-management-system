<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\Country;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_countries');
    }

    public function view(User $user, Country $country): bool
    {
        return $user->can('manage_countries');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_countries');
    }

    public function update(User $user, Country $country): bool
    {
        return $user->can('manage_countries');
    }

    public function delete(User $user, Country $country): bool
    {
        return $user->can('manage_countries');
    }

    public function restore(User $user, Country $country): bool
    {
        return $user->can('manage_countries');
    }

    public function forceDelete(User $user, Country $country): bool
    {
        return $user->hasRole('superadmin');
    }
}
