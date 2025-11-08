<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ImportExportCompleted implements ShouldBroadcast
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * The channel the event should broadcast on.
     */
    public function broadcastOn()
    {
        // use a private channel per user so only the intended user receives the toast
        return new PrivateChannel('import-channel-' . getActiveUser()->id);
    }

    /**
     * Broadcast payload.
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'type' => 'success',
        ];
    }

    /**
     * Broadcast event name used on the frontend.
     */
    public function broadcastAs(): string
    {
        return 'show-toast';
    }
}