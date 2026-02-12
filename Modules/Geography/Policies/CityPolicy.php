<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\City;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_cities');
    }

    public function view(User $user, City $city): bool
    {
        return $user->can('manage_cities');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_cities');
    }

    public function update(User $user, City $city): bool
    {
        return $user->can('manage_cities');
    }

    public function delete(User $user, City $city): bool
    {
        return $user->can('manage_cities');
    }

    public function restore(User $user, City $city): bool
    {
        return $user->can('manage_cities');
    }

    public function forceDelete(User $user, City $city): bool
    {
        return $user->hasRole('superadmin');
    }
}
