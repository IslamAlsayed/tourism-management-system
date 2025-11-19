<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public $activity;

    /**
     * Create a new event instance.
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * The channel the event should broadcast on.
     */
    public function broadcastOn()
    {
        // Broadcast to all authenticated users on public channel
        return new Channel('activities');
    }

    /**
     * Broadcast payload.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->activity->id,
            'description' => $this->activity->description,
            'log_name' => $this->activity->log_name,
            'event' => $this->activity->event,
            'subject_type' => $this->activity->subject_type,
            'subject_id' => $this->activity->subject_id,
            'causer' => $this->activity->causer ? [
                'id' => $this->activity->causer->id,
                'name' => $this->activity->causer->name ?? null,
            ] : null,
            'created_at' => $this->activity->created_at->toDateTimeString(),
        ];
    }

    /**
     * Broadcast event name used on the frontend.
     */
    public function broadcastAs(): string
    {
        return 'activity.created';
    }
}