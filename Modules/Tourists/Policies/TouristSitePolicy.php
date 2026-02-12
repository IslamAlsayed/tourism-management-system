<?php

namespace Modules\Tourists\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;
use Modules\Tourists\Entities\TouristSite;

class TouristSitePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_sites');
    }

    public function view(User $user, TouristSite $site): bool
    {
        return $user->can('manage_sites');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_sites');
    }

    public function update(User $user, TouristSite $site): bool
    {
        return $user->can('manage_sites');
    }

    public function delete(User $user, TouristSite $site): bool
    {
        return $user->can('manage_sites');
    }

    public function restore(User $user, TouristSite $site): bool
    {
        return $user->can('manage_sites');
    }

    public function forceDelete(User $user, TouristSite $site): bool
    {
        return $user->hasRole('superadmin');
    }
}
