<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Modules\Localization\Entities\Currency;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurrencyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any currencies.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_currencies');
    }

    /**
     * Determine whether the user can view the currency.
     */
    public function view(User $user, Currency $currency): bool
    {
        return $user->can('manage_currencies');
    }

    /**
     * Determine whether the user can create currencies.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_currencies');
    }

    /**
     * Determine whether the user can update the currency.
     */
    public function update(User $user, Currency $currency): bool
    {
        return $user->can('manage_currencies');
    }

    /**
     * Determine whether the user can delete the currency.
     */
    public function delete(User $user, Currency $currency): bool
    {
        return $user->can('manage_currencies');
    }

    /**
     * Determine whether the user can restore the currency.
     */
    public function restore(User $user, Currency $currency): bool
    {
        return $user->can('manage_currencies');
    }

    /**
     * Determine whether the user can permanently delete the currency.
     */
    public function forceDelete(User $user, Currency $currency): bool
    {
        return $user->can('superadmin');
    }
}
