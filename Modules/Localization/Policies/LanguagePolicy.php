<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Modules\Localization\Entities\Language;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_languages');
    }

    public function view(User $user, Language $language): bool
    {
        return $user->can('manage_languages');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_languages');
    }

    public function update(User $user, Language $language): bool
    {
        return $user->can('manage_languages');
    }

    public function delete(User $user, Language $language): bool
    {
        return $user->can('manage_languages');
    }

    public function restore(User $user, Language $language): bool
    {
        return $user->can('manage_languages');
    }

    public function forceDelete(User $user, Language $language): bool
    {
        return $user->hasRole('superadmin');
    }
}
