<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait CustomNotifiable
{
    public function notifications(): HasMany
    {
        return $this->hasMany(\App\Models\Notification::class, 'receiver_id');
    }
    public function unreadNotifications(): HasMany
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function readNotifications(): HasMany
    {
        return $this->notifications()->whereNotNull('read_at');
    }


    public function markAllNotificationsAsRead(): void
    {
        $this->unreadNotifications()->update(['read_at' => now()]);
    }
}
