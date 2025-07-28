<?php

namespace App\Jobs;

use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class SendFcmNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tokens;
    protected $title;
    protected $body;
    protected $data;

    public function __construct($tokens, $title, $body, $data = [])
    {
        $this->tokens = $tokens;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    public function handle()
    {
        app(NotificationService::class)->send($this->tokens, $this->title, $this->body, $this->data);
    }
}
