<?php

namespace Modules\Transportation\Policies;

use Modules\Core\Entities\User;
use Modules\Transportation\Entities\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_companies');
    }

    public function view(User $user, Company $company): bool
    {
        return $user->can('manage_companies');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_companies');
    }

    public function update(User $user, Company $company): bool
    {
        return $user->can('manage_companies');
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->can('manage_companies');
    }

    public function restore(User $user, Company $company): bool
    {
        return $user->can('manage_companies');
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return $user->hasRole('superadmin');
    }
}
