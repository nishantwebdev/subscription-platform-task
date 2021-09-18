<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationHistory
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public $user;
    public $website = null;
    public $post = null;
    public $email = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($post, $website, $email)
    {
        $this->website = $website;
        $this->post = $post;
        $this->email = $email;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
