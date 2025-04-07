<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasLikes;
use App\Concerns\HasMentions;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasComments, HasLikes, HasMentions;

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
        'likers','comments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)
        ->select('id','profile_image','username');
    }

    public function getLikesCountAttribute()
    {
        return $this->likers()->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->with(['replies' => function ($query) {
            $query->withCount('replies');
        }])->get()->sum(function ($comment) {
            return 1 + $this->countReplies($comment);
        });
    }

    protected function countReplies($comment)
    {
        if ($comment->replies->isEmpty()) {
            return 0;
        }

        return $comment->replies->sum(function ($reply) {
            return 1 + $this->countReplies($reply);
        });
    }
}
