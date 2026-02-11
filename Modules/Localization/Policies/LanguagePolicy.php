<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Modules\Localization\Entities\Language;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any languages.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_languages');
    }

    /**
     * Determine whether the user can view the language.
     */
    public function view(User $user, Language $language): bool
    {
        return $user->can('manage_languages');
    }

    /**
     * Determine whether the user can create languages.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_languages');
    }

    /**
     * Determine whether the user can update the language.
     */
    public function update(User $user, Language $language): bool
    {
        return $user->can('manage_languages');
    }

    /**
     * Determine whether the user can delete the language.
     */
    public function delete(User $user, Language $language): bool
    {
        return $user->can('manage_languages');
    }

    /**
     * Determine whether the user can restore the language.
     */
    public function restore(User $user, Language $language): bool
    {
        return $user->can('manage_languages');
    }

    /**
     * Determine whether the user can permanently delete the language.
     */
    public function forceDelete(User $user, Language $language): bool
    {
        return $user->can('superadmin');
    }
}
