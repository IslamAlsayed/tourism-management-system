<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Country;

class CountryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Country $country): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Country $country): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Country $country): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Country $country): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Country $country): bool
    {
        return $user->hasRole('superadmin');
    }
}
