<?php

namespace App\Policies;

use App\Models\StarRating;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;

class StarRatingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_star_ratings');
    }

    public function view(User $user, StarRating $starRating): bool
    {
        return $user->can('manage_star_ratings');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_star_ratings');
    }

    public function update(User $user, StarRating $starRating): bool
    {
        return $user->can('manage_star_ratings');
    }

    public function delete(User $user, StarRating $starRating): bool
    {
        return $user->can('manage_star_ratings');
    }

    public function restore(User $user, StarRating $starRating): bool
    {
        return $user->can('manage_star_ratings');
    }

    public function forceDelete(User $user, StarRating $starRating): bool
    {
        return $user->hasRole('superadmin');
    }
}
