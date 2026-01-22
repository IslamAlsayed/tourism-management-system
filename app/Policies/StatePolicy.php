<?php

namespace App\Policies;

use App\Models\User;
use App\Models\State;

class StatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, State $state): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, State $state): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, State $state): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, State $state): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, State $state): bool
    {
        return $user->hasRole('superadmin');
    }
}
