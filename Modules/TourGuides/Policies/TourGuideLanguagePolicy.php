<?php

namespace Modules\TourGuides\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\TourGuides\Entities\TourGuideLanguage;

class TourGuideLanguagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    public function view(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    public function update(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    public function delete(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    public function restore(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    public function forceDelete(User $user, TourGuideLanguage $language): bool
    {
        return $user->hasRole('superadmin');
    }
}
