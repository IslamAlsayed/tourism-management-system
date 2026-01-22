<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Nationality;

class NationalityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Nationality $nationality): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Nationality $nationality): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Nationality $nationality): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Nationality $nationality): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Nationality $nationality): bool
    {
        return $user->hasRole('superadmin');
    }
}
