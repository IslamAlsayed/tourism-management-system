<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Modules\Localization\Entities\Currency;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurrencyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_currencies');
    }

    public function view(User $user, Currency $currency): bool
    {
        return $user->can('manage_currencies');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_currencies');
    }

    public function update(User $user, Currency $currency): bool
    {
        return $user->can('manage_currencies');
    }

    public function delete(User $user, Currency $currency): bool
    {
        return $user->can('manage_currencies');
    }

    public function restore(User $user, Currency $currency): bool
    {
        return $user->can('manage_currencies');
    }

    public function forceDelete(User $user, Currency $currency): bool
    {
        return $user->hasRole('superadmin');
    }
}
