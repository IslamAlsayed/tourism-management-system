<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransportationRoute;

class TransportationRoutePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TransportationRoute $transportationRoute): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TransportationRoute $transportationRoute): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TransportationRoute $transportationRoute): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TransportationRoute $transportationRoute): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TransportationRoute $transportationRoute): bool
    {
        return $user->hasRole('superadmin');
    }
}
