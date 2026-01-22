<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransportationRouteAssignment;

class TransportationRouteAssignmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TransportationRouteAssignment $transportationRouteAssignment): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TransportationRouteAssignment $transportationRouteAssignment): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TransportationRouteAssignment $transportationRouteAssignment): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TransportationRouteAssignment $transportationRouteAssignment): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TransportationRouteAssignment $transportationRouteAssignment): bool
    {
        return $user->hasRole('superadmin');
    }
}
