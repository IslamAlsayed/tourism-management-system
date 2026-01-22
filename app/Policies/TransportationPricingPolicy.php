<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransportationPricing;

class TransportationPricingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TransportationPricing $transportationPricing): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TransportationPricing $transportationPricing): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TransportationPricing $transportationPricing): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TransportationPricing $transportationPricing): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TransportationPricing $transportationPricing): bool
    {
        return $user->hasRole('superadmin');
    }
}
