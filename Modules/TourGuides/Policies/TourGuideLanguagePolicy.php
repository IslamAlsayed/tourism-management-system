<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\TourGuides\Entities\TourGuideLanguage;

class TourGuideLanguagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tour guide languages.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    /**
     * Determine whether the user can view the tour guide language.
     */
    public function view(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    /**
     * Determine whether the user can create tour guide languages.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    /**
     * Determine whether the user can update the tour guide language.
     */
    public function update(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    /**
     * Determine whether the user can delete the tour guide language.
     */
    public function delete(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    /**
     * Determine whether the user can restore the tour guide language.
     */
    public function restore(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('manage_tour_guide_languages');
    }

    /**
     * Determine whether the user can permanently delete the tour guide language.
     */
    public function forceDelete(User $user, TourGuideLanguage $language): bool
    {
        return $user->can('superadmin');
    }
}
