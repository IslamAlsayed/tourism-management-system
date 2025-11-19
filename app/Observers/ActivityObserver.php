<?php

namespace App\Observers;

use Spatie\Activitylog\Models\Activity;
use App\Events\ActivityCreated;

class ActivityObserver
{
    public function created(Activity $activity)
    {
        // Fire broadcast event
        event(new ActivityCreated($activity));
    }

    public function updated(Activity $activity)
    {
        // you can reuse event class or create ActivityUpdated
        event(new ActivityCreated($activity)); // أو ActivityUpdated
    }

    public function deleted(Activity $activity)
    {
        // optional
        event(new ActivityCreated($activity));
    }
}