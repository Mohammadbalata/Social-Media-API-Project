<?php

namespace App\Concerns;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasLikes
{
    protected static function bootHasLikes(): void
    {
        static::deleting(function ($model) {
            $model->likes()->delete();
            $model->unsetRelation('likes');
        });
    }

    public function likedBy(User $user): void
    {
        $this->likes()->create(['user_id' => $user->id]);
        $this->unsetRelation('likes');
    }

    public function dislikedBy(User $user): void
    {
        optional($this->likes()->where('user_id', $user->id)->first())->delete();
        $this->unsetRelation('likes');
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function likers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Like::class, 'likeable_id')
            ->where('likeable_type', array_search(static::class, Relation::morphMap()) ?: static::class)
            ->select('user_id', 'username', 'profile_image');
    }
}
