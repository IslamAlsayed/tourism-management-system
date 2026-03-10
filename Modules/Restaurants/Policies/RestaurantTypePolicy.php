<?php

namespace Modules\Restaurants\Policies;

use Modules\Core\Entities\User;
use Modules\Restaurants\Entities\RestaurantType;

class RestaurantTypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_restaurants');
    }

    public function view(User $user, RestaurantType $restaurantType): bool
    {
        return $user->can('manage_restaurants');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_restaurants');
    }

    public function update(User $user, RestaurantType $restaurantType): bool
    {
        return $user->can('manage_restaurants');
    }

    public function delete(User $user, RestaurantType $restaurantType): bool
    {
        return $user->can('manage_restaurants');
    }

    public function restore(User $user, RestaurantType $restaurantType): bool
    {
        return $user->can('manage_restaurants');
    }

    public function forceDelete(User $user, RestaurantType $restaurantType): bool
    {
        return $user->hasRole('superadmin');
    }
}
