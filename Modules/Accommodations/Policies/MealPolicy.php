<?php

namespace Modules\Accommodations\Policies;

use Modules\Core\Entities\User;
use Modules\Accommodations\Entities\Meal;

class MealPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_meals');
    }

    public function view(User $user, Meal $meal): bool
    {
        return $user->can('manage_meals');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_meals');
    }

    public function update(User $user, Meal $meal): bool
    {
        return $user->can('manage_meals');
    }

    public function delete(User $user, Meal $meal): bool
    {
        return $user->can('manage_meals');
    }

    public function restore(User $user, Meal $meal): bool
    {
        return $user->can('manage_meals');
    }

    public function forceDelete(User $user, Meal $meal): bool
    {
        return $user->can('manage_meals');
    }
}
