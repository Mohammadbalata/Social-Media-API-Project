<?php

namespace App\Listeners;

use App\Events\UserFollowed;
use App\Notifications\UserFollowedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFollowNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserFollowed $event): void
    {
        // Send notification to the user
        $user = $event->user;
        $follower = $event->follower;

        // Assuming you have a Notification class set up
        $user->notify(new UserFollowedNotification($follower));
    }
}
