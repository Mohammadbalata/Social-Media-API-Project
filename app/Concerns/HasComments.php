<?php

namespace App\Concerns;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasComments
{
    protected static function bootHasComments(): void
    {
        static::deleting(function ($model) {
            $model->comments()->delete();
            $model->unsetRelation('comments');
        });
    }

    public function commentedBy(User $user, string $content): void
    {
        $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content,
        ]);
        $this->unsetRelation('comments');
    }

    public function isCommentedBy(User $user): bool
    {
        return $this->comments()->where('user_id', $user->id)->exists();
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function commenters(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Comment::class, 'commentable_id')
            ->where('commentable_type', array_search(static::class, Relation::morphMap()) ?: static::class);
    }
}
