<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{


    public function index()
    {
        $user  = authUser();
        $notifications =  $user
            ->notifications()
            ->latest()
            ->paginate(10);


        $markAsRead = $user->unreadNotifications;

        foreach ($markAsRead as $notification) {
            $notification->update([
                "read_at" => now()
            ]);
        }

        return jsonResponse(
            true,
            200,
            'Notifications fetched successfully',
            [
                "notifications" => $notifications,
                "current_page" => $notifications->currentPage(),
                "last_page" => $notifications->lastPage(),
                "total" => $notifications->count(),
                "unread_notifications" => $user->unreadNotifications()->count(),
            ]
        );
    }

    public function markAsRead(Notification $notification)
    {
        $user = authUser();
        if ($notification->receiver_id !== $user->id) {
            return jsonResponse(false, 403, 'Unauthorized action');
        }
      
        if ($notification->isRead()) {
            return jsonResponse(false, 400, 'Notification already read');
        }

        $notification->markAsRead();

        return jsonResponse(true, 200, 'Notification marked as read', [
            'notification' => $notification,
        ]);
    }

    public function markAllAsRead()
    {
        $user = authUser();
        $user->markAllNotificationsAsRead();

        return jsonResponse(true, 200, 'All notifications marked as read', [
            'unread_notifications' => $user->unreadNotifications()->count(),
        ]);
    }
}
