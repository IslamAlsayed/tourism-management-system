<?php

namespace Modules\Accommodations\Policies;

use Modules\Core\Entities\User;
use Modules\Accommodations\Entities\Season;

class SeasonPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_seasons');
    }

    public function view(User $user, Season $season): bool
    {
        return $user->can('manage_seasons');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_seasons');
    }

    public function update(User $user, Season $season): bool
    {
        return $user->can('manage_seasons');
    }

    public function delete(User $user, Season $season): bool
    {
        return $user->can('manage_seasons');
    }

    public function restore(User $user, Season $season): bool
    {
        return $user->can('manage_seasons');
    }

    public function forceDelete(User $user, Season $season): bool
    {
        return $user->hasRole('superadmin');
    }
}
