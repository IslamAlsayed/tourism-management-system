<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\CityState;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityStatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_city_states');
    }

    public function view(User $user, CityState $cityState): bool
    {
        return $user->can('manage_city_states');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_city_states');
    }

    public function update(User $user, CityState $cityState): bool
    {
        return $user->can('manage_city_states');
    }

    public function delete(User $user, CityState $cityState): bool
    {
        return $user->can('manage_city_states');
    }

    public function restore(User $user, CityState $cityState): bool
    {
        return $user->can('manage_city_states');
    }

    public function forceDelete(User $user, CityState $cityState): bool
    {
        return $user->hasRole('superadmin');
    }
}
