<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Meal;

class MealPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Meal $meal): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Meal $meal): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Meal $meal): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Meal $meal): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Meal $meal): bool
    {
        return $user->hasRole('superadmin');
    }
}
