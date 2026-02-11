<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use App\Models\MediaFile;

class MediaFilePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_media');
    }

    public function view(User $user, MediaFile $mediaFile): bool
    {
        return $user->can('manage_media');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_media');
    }

    public function update(User $user, MediaFile $mediaFile): bool
    {
        return $user->can('manage_media');
    }

    public function delete(User $user, MediaFile $mediaFile): bool
    {
        return $user->can('manage_media');
    }

    public function restore(User $user, MediaFile $mediaFile): bool
    {
        return $user->can('manage_media');
    }

    public function forceDelete(User $user, MediaFile $mediaFile): bool
    {
        return $user->can('manage_media');
    }
}
