<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class  NotificationService
{
    public function __construct(
        private FirebaseService $firebaseService
    ) {}

    public function send(array|string $recipients, string $title, string $body, array $data, $saveNotification = true): void
    {
        // Store notification in database
        if (!$saveNotification) {
            return;
        }

        // Notification::create([
        //     "title" => $title,
        //     "body" => $body,
        //     ...$data
        // ]);


        $message = $this->prepareMessage($title, $body, $data);
        $this->sendFirebaseNotification($recipients, $message);
    }

    private function prepareMessage(string $title, string $body, array $data): array
    {
        return [
            'notification' => ['title' => $title, 'body' => $body],
            'data' => array_map(
                function ($value) {
                    if (is_array($value)) {
                        return json_encode($value, JSON_UNESCAPED_UNICODE);
                    }
                    return (string)$value;
                },
                $data
            ),
            'android' => [
                'notification' => ['channel_id' => "family_selah_id"]
            ],
            'apns' => [ 
                'payload' => [
                    'aps' => [
                        'sound' => "custom_sound.caf"
                    ]
                ]
            ]
        ];
    }

    private function sendFirebaseNotification(array|string $recipients, array $message): void
    {
        try {
            if (is_array($recipients)) {
                if (empty($recipients)) {
                    Log::info("No FCM tokens provided for notification");
                    return;
                }
                $this->firebaseService->getMessaging()->sendMulticast($message, $recipients);
            } else {
                $message['topic'] = $recipients;
                $this->firebaseService->getMessaging()->send($message);
            }

            Log::info("Notification sent successfully to " . (is_array($recipients) ? count($recipients) . " recipients" : "topic: $recipients"));
        } catch (\Exception $e) {
            Log::error('Failed to send Firebase notification: ' . $e->getMessage());
        }
    }
}
