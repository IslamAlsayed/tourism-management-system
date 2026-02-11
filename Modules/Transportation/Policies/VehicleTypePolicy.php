<?php

namespace Modules\Transportation\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Transportation\Entities\VehicleType;

class VehicleTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_vehicle_types');
    }

    public function view(User $user, VehicleType $vehicleType): bool
    {
        return $user->can('manage_vehicle_types');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_vehicle_types');
    }

    public function update(User $user, VehicleType $vehicleType): bool
    {
        return $user->can('manage_vehicle_types');
    }

    public function delete(User $user, VehicleType $vehicleType): bool
    {
        return $user->can('manage_vehicle_types');
    }

    public function restore(User $user, VehicleType $vehicleType): bool
    {
        return $user->can('manage_vehicle_types');
    }

    public function forceDelete(User $user, VehicleType $vehicleType): bool
    {
        return $user->can('manage_vehicle_types');
    }
}
