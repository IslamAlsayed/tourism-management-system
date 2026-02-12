<?php

namespace Modules\Core\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Activitylog\Models\Activity;

class ActivityPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Activity $activity): bool
    {
        return $user->can('manage_activities');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_activities');
    }

    public function update(User $user, Activity $activity): bool
    {
        return $user->can('manage_activities');
    }

    public function delete(User $user, Activity $activity): bool
    {
        return $user->can('manage_activities');
    }

    public function restore(User $user, Activity $activity): bool
    {
        return $user->can('manage_activities');
    }

    public function forceDelete(User $user, Activity $activity): bool
    {
        return $user->hasRole('superadmin');
    }
}
