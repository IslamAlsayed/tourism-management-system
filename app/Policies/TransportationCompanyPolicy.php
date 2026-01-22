<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransportationCompany;

class TransportationCompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TransportationCompany $transportationCompany): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TransportationCompany $transportationCompany): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TransportationCompany $transportationCompany): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TransportationCompany $transportationCompany): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TransportationCompany $transportationCompany): bool
    {
        return $user->hasRole('superadmin');
    }
}
