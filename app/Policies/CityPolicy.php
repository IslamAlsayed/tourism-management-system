<?php

namespace App\Policies;

use App\Models\User;
use App\Models\City;

class CityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, City $city): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, City $city): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, City $city): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, City $city): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, City $city): bool
    {
        return $user->hasRole('superadmin');
    }
}
