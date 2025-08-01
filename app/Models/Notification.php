<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'body',
        'type',
        'sender_id',
        'receiver_id',
        'model_id',
        'model_type',
        'read_at',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function getModelDataAttribute()
    {
        if (!$this->model_id) {
            return null;
        }

        if ($this->model_type == User::class) {
            return $this->model_type::find($this->model_id);
        }

        return null;
    }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function markAsUnread(): void
    {
        $this->update(['read_at' => null]);
    }
}
