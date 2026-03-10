<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Foundation\Events\Dispatchable;

class ActivityCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Activity $activity)
    {
        $this->activity = $activity;
    }
}
