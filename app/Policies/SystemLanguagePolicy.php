<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SystemLanguage;

class SystemLanguagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, SystemLanguage $systemLanguage): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function update(User $user, SystemLanguage $systemLanguage): bool
    {
        return $user->hasRole('superadmin');
    }

    public function delete(User $user, SystemLanguage $systemLanguage): bool
    {
        return $user->hasRole('superadmin');
    }

    public function restore(User $user, SystemLanguage $systemLanguage): bool
    {
        return $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, SystemLanguage $systemLanguage): bool
    {
        return $user->hasRole('superadmin');
    }
}
