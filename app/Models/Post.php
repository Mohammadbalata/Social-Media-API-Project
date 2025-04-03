<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasLikes;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasComments, HasLikes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'type',
        'privacy',
        'is_pinned',
        'shares',
    ];

    protected $with = [
        'likers',
    ];

    protected $appends = [
        'likes_count',
        'comments_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likers()->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }
}
