<?php

namespace Modules\TravelDocuments\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\TravelDocuments\Entities\VisaRequirement;

class VisaRequirementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_visa_requirements');
    }

    public function view(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->can('manage_visa_requirements');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_visa_requirements');
    }

    public function update(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->can('manage_visa_requirements');
    }

    public function delete(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->can('manage_visa_requirements');
    }

    public function restore(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->can('manage_visa_requirements');
    }

    public function forceDelete(User $user, VisaRequirement $visaRequirement): bool
    {
        return $user->can('manage_visa_requirements');
    }
}
