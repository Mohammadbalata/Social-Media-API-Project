<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasLikes;
use App\Concerns\HasMentions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use  HasComments, HasLikes,HasMentions;

    protected $fillable = [
        'user_id',
        'content',
        'commentable_id',
        'commentable_type',
        'parent_id'
    ];

    protected $with = ['replies', 'likers'];

    protected $appends = ['likes_count',];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function getLikesCountAttribute()
    {
        return $this->likers()->count();
    }
}
