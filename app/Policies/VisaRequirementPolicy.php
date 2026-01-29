<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VisaRequirement;

class VisaRequirementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->hasRole('superadmin');
    }
}
