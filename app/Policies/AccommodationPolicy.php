<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use Modules\Accommodations\Entities\Accommodation;

class AccommodationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_accommodations') || $user->hasRole('superadmin');
    }

    public function view(User $user, Accommodation $accommodation): bool
    {
        return $user->can('manage_accommodations') || $user->hasRole('superadmin');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_accommodations') || $user->hasRole('superadmin');
    }

    public function update(User $user, Accommodation $accommodation): bool
    {
        return $user->can('manage_accommodations') || $user->hasRole('superadmin');
    }

    public function delete(User $user, Accommodation $accommodation): bool
    {
        return $user->can('manage_accommodations') || $user->hasRole('superadmin');
    }

    public function restore(User $user, Accommodation $accommodation): bool
    {
        return $user->can('manage_accommodations') || $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, Accommodation $accommodation): bool
    {
        return $user->hasRole('superadmin');
    }
}
