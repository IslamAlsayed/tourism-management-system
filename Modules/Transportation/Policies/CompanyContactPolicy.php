<?php

namespace Modules\Transportation\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Transportation\Entities\CompanyContact;

class CompanyContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_company_contacts');
    }

    public function view(User $user, CompanyContact $companyContact): bool
    {
        return $user->can('manage_company_contacts');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_company_contacts');
    }

    public function update(User $user, CompanyContact $companyContact): bool
    {
        return $user->can('manage_company_contacts');
    }

    public function delete(User $user, CompanyContact $companyContact): bool
    {
        return $user->can('manage_company_contacts');
    }

    public function restore(User $user, CompanyContact $companyContact): bool
    {
        return $user->can('manage_company_contacts');
    }

    public function forceDelete(User $user, CompanyContact $companyContact): bool
    {
        return $user->can('manage_company_contacts');
    }
}
