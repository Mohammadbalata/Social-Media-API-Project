<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'type',
        'file_size',
        'mediable_type',
        'mediable_id'
    ];

    
}
