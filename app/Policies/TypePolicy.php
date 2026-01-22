<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Type;

class TypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Type $type): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Type $type): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Type $type): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Type $type): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Type $type): bool
    {
        return $user->hasRole('superadmin');
    }
}
