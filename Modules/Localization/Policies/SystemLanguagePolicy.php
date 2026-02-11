<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Localization\Entities\SystemLanguage;

class SystemLanguagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any system languages.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_system_languages');
    }

    /**
     * Determine whether the user can view the system language.
     */
    public function view(User $user, SystemLanguage $language): bool
    {
        return $user->can('manage_system_languages');
    }

    /**
     * Determine whether the user can create system languages.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_system_languages');
    }

    /**
     * Determine whether the user can update the system language.
     */
    public function update(User $user, SystemLanguage $language): bool
    {
        return $user->can('manage_system_languages');
    }

    /**
     * Determine whether the user can delete the system language.
     */
    public function delete(User $user, SystemLanguage $language): bool
    {
        return $user->can('manage_system_languages');
    }

    /**
     * Determine whether the user can restore the system language.
     */
    public function restore(User $user, SystemLanguage $language): bool
    {
        return $user->can('manage_system_languages');
    }

    /**
     * Determine whether the user can permanently delete the system language.
     */
    public function forceDelete(User $user, SystemLanguage $language): bool
    {
        return $user->can('superadmin');
    }
}