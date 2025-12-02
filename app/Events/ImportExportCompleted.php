<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ImportExportCompleted implements ShouldBroadcast
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public $message;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct($message, $userId = null)
    {
        $this->message = $message;
        $this->userId = $userId;
    }

    /**
     * The channel the event should broadcast on.
     */
    public function broadcastOn()
    {
        // if a user id was provided, broadcast on that user's private channel
        if ($this->userId) {
            return new PrivateChannel('import-channel-' . $this->userId);
        }

        // fallback: broadcast on a public channel so listeners can show general toasts
        return new Channel('import-channel');
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