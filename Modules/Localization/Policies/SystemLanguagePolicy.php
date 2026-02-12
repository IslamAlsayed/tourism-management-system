<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Localization\Entities\SystemLanguage;

class SystemLanguagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_system_languages');
    }

    public function view(User $user, SystemLanguage $language): bool
    {
        return $user->can('manage_system_languages');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_system_languages');
    }

    public function update(User $user, SystemLanguage $language): bool
    {
        return $user->can('manage_system_languages');
    }

    public function delete(User $user, SystemLanguage $language): bool
    {
        return $user->can('manage_system_languages');
    }

    public function restore(User $user, SystemLanguage $language): bool
    {
        return $user->can('manage_system_languages');
    }

    public function forceDelete(User $user, SystemLanguage $language): bool
    {
        return $user->hasRole('superadmin');
    }
}
