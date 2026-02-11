<?php

namespace App\Events;

use Modules\Core\Entities\User;

class UserLoggedEvent
{
    public function __construct(public User $user, public $status)
    {
        $this->user = $user;
        $this->status = $status;
    }
}
