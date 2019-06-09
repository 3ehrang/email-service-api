<?php

namespace App\Events;

use App\Models\Data\EmailData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OperationFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var EmailData
     */
    public $emailData;

    /**
     * @var string Service Id
     */
    public $sid;

    /**
     * Create a new event instance.
     *
     * @param EmailData $emailData
     * @param string $sid
     *
     * @return void
     */
    public function __construct(EmailData $emailData, $sid)
    {
        $this->emailData = $emailData;
        $this->sid = $sid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
    }
}
