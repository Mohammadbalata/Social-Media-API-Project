<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\FcmOptions;

class CommentCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $user , public $commentable,public $model) // model in this case is a commment or reply 
    {
        $this->user = $user;
        $this->model = $model;
        $this->commentable = $commentable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $modelType = strtolower(class_basename($this->commentable));

        if($modelType == 'post'){
            $modelId = $this->commentable->id;
            return (new MailMessage)
                ->subject('New Comment on Your Post')
                ->greeting('Hello!')
                ->line("@{$this->user->username} commented on your post.")
                ->action('View Comment', url('/posts/' . $modelId))
                ->line('Thank you for using our application!');
        }
        if($modelType == 'comment'){
            $modelId = $this->commentable->id;
            return (new MailMessage)
                ->subject('New Reply to Your Comment')
                ->greeting('Hello!')
                ->line("@{$this->user->username} replied to your comment.")
                ->action('View Comment', url('/comments/' . $modelId))
                ->line('Thank you for using our application!');
        }
        
        return (new MailMessage);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
