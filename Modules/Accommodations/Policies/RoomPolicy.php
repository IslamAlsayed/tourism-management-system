<?php

namespace Modules\Accommodations\Policies;

use Modules\Core\Entities\User;
use Modules\Accommodations\Entities\Room;

class RoomPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_rooms');
    }

    public function view(User $user, Room $room): bool
    {
        return $user->can('manage_rooms');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_rooms');
    }

    public function update(User $user, Room $room): bool
    {
        return $user->can('manage_rooms');
    }

    public function delete(User $user, Room $room): bool
    {
        return $user->can('manage_rooms');
    }

    public function restore(User $user, Room $room): bool
    {
        return $user->can('manage_rooms');
    }

    public function forceDelete(User $user, Room $room): bool
    {
        return $user->can('manage_rooms');
    }
}
