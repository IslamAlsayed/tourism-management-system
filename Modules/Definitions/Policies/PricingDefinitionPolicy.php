<?php

namespace Modules\Definitions\Policies;

use Modules\Core\Entities\User;
use Modules\Definitions\Entities\PricingDefinition;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricingDefinitionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function view(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole('superadmin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function update(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole('superadmin');
    }

    public function delete(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole('superadmin');
    }

    public function restore(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, PricingDefinition $pricingDefinition): bool
    {
        return $user->hasRole('superadmin');
    }
}
