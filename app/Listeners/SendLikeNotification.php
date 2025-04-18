<?php

namespace App\Listeners;

use App\Events\ModelLiked;
use App\Notifications\LikedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendLikeNotification
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
    public function handle(ModelLiked $event): void
    {
        // Send notification to the user
        $user = $event->user;
        $post = $event->model;
        // Assuming you have a Notification class set up
        $post->user->notify(new LikedNotification($user, $post));
    }
}
