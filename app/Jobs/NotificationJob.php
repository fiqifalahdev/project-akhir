<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messaging;
    public $deviceToken;
    public $title;
    public $body;

    /**
     * Create a new job instance.
     */
    public function __construct(string $deviceToken, string $title, string $body)
    {
        $this->deviceToken = $deviceToken;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->messaging = app('firebase.messaging');

        // handle notification here
        $message = CloudMessage::withTarget('token', $this->deviceToken)
            ->withNotification([
                'title' => $this->title,
                'body' => $this->body
            ]);

        $this->messaging->send($message);

        logger('Notification sent!');
    }
}
