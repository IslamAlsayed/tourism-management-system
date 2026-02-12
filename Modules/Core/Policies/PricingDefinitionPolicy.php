<?php

namespace Modules\Core\Policies;

use Modules\Core\Entities\User;
use Modules\Core\Entities\PricingDefinition;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricingDefinitionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_pricing_definitions');
    }

    public function view(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->can('manage_pricing_definitions');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_pricing_definitions');
    }

    public function update(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->can('manage_pricing_definitions');
    }

    public function delete(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->can('manage_pricing_definitions');
    }

    public function restore(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->can('manage_pricing_definitions');
    }

    public function forceDelete(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole('superadmin');
    }
}
