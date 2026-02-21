<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueCalled implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $queueNumber;
    public $doctorName;

    /**
     * Create a new event instance.
     */
    public function __construct($queueNumber, $doctorName)
    {
        $this->queueNumber = $queueNumber;
        $this->doctorName = $doctorName;
    }

    /**
     * Channel yang akan digunakan
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('queue-channel'),
        ];
    }

    /**
     * Nama event di frontend
     */
    public function broadcastAs(): string
    {
        return 'queue.called';
    }
}