<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StarRating;

class StarRatingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, StarRating $starRating): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, StarRating $starRating): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, StarRating $starRating): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, StarRating $starRating): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, StarRating $starRating): bool
    {
        return $user->hasRole('superadmin');
    }
}
