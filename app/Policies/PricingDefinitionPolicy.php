<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use App\Models\PricingDefinition;

class PricingDefinitionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole('superadmin');
    }
}
