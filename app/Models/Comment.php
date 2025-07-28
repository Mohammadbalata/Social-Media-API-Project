<?php

namespace App\Models;

use App\Concerns\HasLikes;
use App\Concerns\HasMedia;
use App\Concerns\HasMentions;
use App\Concerns\HasTags;
use App\Traits\HasBlockFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory,
        HasLikes,
        HasMentions,
        HasBlockFilter,
        HasMedia,
        HasTags;

    protected $fillable = [
        'user_id',
        'content',
        'post_id',
        'parent_id'
    ];

    protected $with = [
        'user:id,username,avatar,is_verified',
        'mentionedUsers:id,username',
    ];

    protected $withCount = [
        'likes',
        // 'replies'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get the top-level post for this comment, even if it's a reply.
     */
    public function rootPost()
    {
        return $this->parent ? $this->parent->rootPost() : $this->post;
    }
}
