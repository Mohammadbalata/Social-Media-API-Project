<?php

namespace App\Models;

use App\Traits\HasBlockFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Like extends Model
{
    use HasBlockFilter,
        HasFactory;

    protected $fillable = ['user_id'];
}
