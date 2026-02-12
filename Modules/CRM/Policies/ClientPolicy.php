<?php

namespace Modules\CRM\Policies;

use Modules\Core\Entities\User;
use Modules\CRM\Entities\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_clients');
    }

    public function view(User $user, Client $client): bool
    {
        return $user->can('manage_clients');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_clients');
    }

    public function update(User $user, Client $client): bool
    {
        return $user->can('manage_clients');
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->can('manage_clients');
    }

    public function restore(User $user, Client $client): bool
    {
        return $user->can('manage_clients');
    }

    public function forceDelete(User $user, Client $client): bool
    {
        return $user->hasRole('superadmin');
    }
}
