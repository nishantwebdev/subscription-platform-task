<?php

namespace App\Listeners;

use App\Providers\NotificationHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserNotificationHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationHistory  $event
     * @return void
     */
    public function handle(NotificationHistory $event)
    {
        \Log::info('User Notified for a new post by email', ['website' => $event->website,'post'=> $event->post,'email'=> $event->email]);
    }
}
