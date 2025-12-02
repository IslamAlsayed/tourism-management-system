<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DataStorageMessage implements ShouldBroadcast
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public $message;
    public $error;

    public function __construct(string $message, ?string $error = null)
    {
        $this->message = $message;
        $this->error = $error;
    }

    public function broadcastOn()
    {
        return new Channel('data-storage');
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'error' => $this->error,
        ];
    }

    public function broadcastAs(): string
    {
        return 'data-storage-message';
    }
}
