<?php

namespace App\Observers;

use Spatie\Activitylog\Models\Activity;
use App\Events\ActivityCreated;

class ActivityObserver
{
    public function created(Activity $activity)
    {
        // Prevent infinite loop: Don't fire event for activity logs about activity logs
        if ($activity->log_name === 'models' && $activity->subject_type !== Activity::class) {
            event(new ActivityCreated($activity));
        }
    }

    public function updated(Activity $activity)
    {
        // Prevent infinite loop
        if ($activity->log_name === 'models' && $activity->subject_type !== Activity::class) {
            event(new ActivityCreated($activity));
        }
    }

    public function deleted(Activity $activity)
    {
        // Prevent infinite loop
        if ($activity->log_name === 'models' && $activity->subject_type !== Activity::class) {
            event(new ActivityCreated($activity));
        }
    }
}