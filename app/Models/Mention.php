<?php

namespace App\Models;

use App\Traits\HasBlockFilter;
use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    use HasBlockFilter;
    protected $fillable = [
        'user_id',
        'mentionable_id',
        'mentionable_type',
    ];
}
