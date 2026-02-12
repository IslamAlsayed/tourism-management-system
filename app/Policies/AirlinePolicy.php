<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use App\Models\Airline;

class AirlinePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_airlines');
    }

    public function view(User $user, Airline $airline): bool
    {
        return $user->can('manage_airlines');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_airlines');
    }

    public function update(User $user, Airline $airline): bool
    {
        return $user->can('manage_airlines');
    }

    public function delete(User $user, Airline $airline): bool
    {
        return $user->can('manage_airlines');
    }

    public function restore(User $user, Airline $airline): bool
    {
        return $user->can('manage_airlines');
    }

    public function forceDelete(User $user, Airline $airline): bool
    {
        return $user->hasRole('superadmin');
    }
}
