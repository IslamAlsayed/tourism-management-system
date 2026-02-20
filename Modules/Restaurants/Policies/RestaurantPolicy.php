<?php

namespace Modules\Restaurants\Policies;

use Modules\Core\Entities\User;
use Modules\Restaurants\Entities\Restaurant;

class RestaurantPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_restaurants');
    }

    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->can('manage_restaurants');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_restaurants');
    }

    public function update(User $user, Restaurant $restaurant): bool
    {
        return $user->can('manage_restaurants');
    }

    public function delete(User $user, Restaurant $restaurant): bool
    {
        return $user->can('manage_restaurants');
    }

    public function restore(User $user, Restaurant $restaurant): bool
    {
        return $user->can('manage_restaurants');
    }

    public function forceDelete(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('superadmin');
    }
}