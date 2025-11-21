<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NotificationCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Notification $notification)
    {
        $this->notification = $notification;
    }
}