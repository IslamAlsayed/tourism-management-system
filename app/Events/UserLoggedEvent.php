<?php

namespace App\Events;

use App\Models\User;

class UserLoggedEvent
{
    public function __construct(public User $user, public $status)
    {
        $this->user = $user;
        $this->status = $status;
    }
}