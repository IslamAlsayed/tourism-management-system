<?php

namespace App\Events;

use App\Models\User;

class RecordEvent
{
    public function __construct(public User $user, public $status, public $record = null, public $type = null)
    {
        $this->user = $user;
        $this->status = $status;
        $this->record = $record;
        $this->type = $type;
    }
}