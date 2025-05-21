<?php

namespace App\Models;

use App\Concerns\HasLikes;
use App\Concerns\HasMedia;
use App\Concerns\HasMentions;
use App\Concerns\HasTags;
use App\Traits\VisibilityScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Post extends Model
{

    use HasFactory,
        HasLikes,
        HasMentions,
        HasMedia,
        VisibilityScope,
        HasTags,
        Searchable;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
        'is_pinned',
        'shares',
    ];

    protected $with = [
        'user',
        'likes',
        'mentionedUsers:id,username',
        
    ];

    protected $withCount = [
        'likes',
        'allComments',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }


    public function commenters(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Comment::class, 'post_id', 'user_id')
                    ->distinct();
    }

    
    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

   
    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }

    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
