<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasLikes;
use App\Concerns\HasMedia;
use App\Concerns\HasMentions;
use App\Concerns\HasTags;
use App\Traits\VisibilityScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    use HasFactory,
        HasComments,
        HasLikes,
        HasMentions,
        HasMedia,
        VisibilityScope,
        HasTags;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
        'is_pinned',
        'shares',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $with = [
        'user:id,username,avatar,is_verified',
        'mentionedUsers:id,username',
    ];

    protected $withCount = [
		'likes',
        'comments'
	];

    // public function getLikesCountAttribute()
    // {
    //     return $this->likers()->count();
    // }

    // public function getCommentsCountAttribute()
    // {
    //     return $this->comments()->with(['replies' => function ($query) {
    //         $query->withCount('replies');
    //     }])->get()->sum(function ($comment) {
    //         return 1 + $this->countReplies($comment);
    //     });
    // }

    // protected function countReplies($comment)
    // {
    //     if ($comment->replies->isEmpty()) {
    //         return 0;
    //     }

    //     return $comment->replies->sum(function ($reply) {
    //         return 1 + $this->countReplies($reply);
    //     });
    // }


    public function listRelationships()
    {
        $relations = [];

        foreach ((new \ReflectionClass($this))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if (
                $method->class == get_class($this) &&
                !$method->getParameters() &&
                $method->getReturnType() &&
                strpos($method->getReturnType(), 'Illuminate\Database\Eloquent\Relations') !== false
            ) {
                $relations[] = $method->getName();
            }
        }

        return $relations;
    }
}
