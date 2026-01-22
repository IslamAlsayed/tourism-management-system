<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Region;

class RegionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Region $region): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Region $region): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Region $region): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Region $region): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Region $region): bool
    {
        return $user->hasRole('superadmin');
    }
}
