<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Language;

class LanguagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Language $language): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Language $language): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Language $language): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Language $language): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Language $language): bool
    {
        return $user->hasRole('superadmin');
    }
}
