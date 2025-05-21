<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\CommentCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentCreatedNotification
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
    public function handle(CommentCreated $event): void
    {
        // Send notification to the user
        $user = $event->user;

        $model = $event->model;
        $commentable = $model->commentable;
        $commentable->user->notify(new CommentCreatedNotification($user, $commentable, $model));

        
    }
}
