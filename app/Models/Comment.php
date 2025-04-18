<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasLikes;
use App\Concerns\HasMedia;
use App\Concerns\HasMentions;
use App\Concerns\HasTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory,
        HasComments,
        HasLikes,
        HasMentions,
        HasMedia,
        HasTags;

    protected $fillable = [
        'user_id',
        'content',
        'commentable_id',
        'commentable_type',
        'parent_id'
    ];

    protected $with = [
        'user:id,username,avatar,is_verified',
        'mentionedUsers:id,username'
    ];

    protected $withCount = [
        "likes"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'commentable_id');
    }


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
