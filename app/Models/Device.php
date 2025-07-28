<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        "user_id",
        "device_name",
        "device_os",
        "device_type",
        "ip_address",
        "fcm_token"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
