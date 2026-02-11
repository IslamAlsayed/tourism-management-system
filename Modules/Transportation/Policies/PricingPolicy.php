<?php

namespace Modules\Transportation\Policies;

use Modules\Core\Entities\User;
use Modules\Transportation\Entities\Pricing;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_pricings');
    }

    public function view(User $user, Pricing $pricing): bool
    {
        return $user->can('manage_pricings');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_pricings');
    }

    public function update(User $user, Pricing $pricing): bool
    {
        return $user->can('manage_pricings');
    }

    public function delete(User $user, Pricing $pricing): bool
    {
        return $user->can('manage_pricings');
    }

    public function restore(User $user, Pricing $pricing): bool
    {
        return $user->can('manage_pricings');
    }

    public function forceDelete(User $user, Pricing $pricing): bool
    {
        return $user->can('manage_pricings');
    }
}
