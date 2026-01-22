<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TouristService;

class TouristServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TouristService $touristService): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TouristService $touristService): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TouristService $touristService): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TouristService $touristService): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TouristService $touristService): bool
    {
        return $user->hasRole('superadmin');
    }
}
