<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CityState;

class CityStatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, CityState $cityState): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, CityState $cityState): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, CityState $cityState): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, CityState $cityState): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, CityState $cityState): bool
    {
        return $user->hasRole('superadmin');
    }
}
