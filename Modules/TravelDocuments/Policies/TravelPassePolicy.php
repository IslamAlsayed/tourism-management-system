<?php

namespace Modules\TravelDocuments\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\TravelDocuments\Entities\TravelPasse;

class TravelPassePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_travel_passes');
    }

    public function view(User $user, TravelPasse $travelPasse): bool
    {
        return $user->can('manage_travel_passes');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_travel_passes');
    }

    public function update(User $user, TravelPasse $travelPasse): bool
    {
        return $user->can('manage_travel_passes');
    }

    public function delete(User $user, TravelPasse $travelPasse): bool
    {
        return $user->can('manage_travel_passes');
    }

    public function restore(User $user, TravelPasse $travelPasse): bool
    {
        return $user->can('manage_travel_passes');
    }

    public function forceDelete(User $user, TravelPasse $travelPasse): bool
    {
        return $user->hasRole('superadmin');
    }
}
