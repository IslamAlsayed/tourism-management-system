<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supplement;

class SupplementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Supplement $supplement): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Supplement $supplement): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Supplement $supplement): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Supplement $supplement): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Supplement $supplement): bool
    {
        return $user->hasRole('superadmin');
    }
}
