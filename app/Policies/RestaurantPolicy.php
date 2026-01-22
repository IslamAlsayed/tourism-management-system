<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Restaurant;

class RestaurantPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('superadmin');
    }
}
