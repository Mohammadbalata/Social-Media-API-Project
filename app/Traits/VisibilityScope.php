<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait VisibilityScope
{
    /**
     * Base visible to scope
     */
    public function scopeVisibleTo(Builder $query, ?User $viewer = null): Builder
    {
        return $query->when(
            !$viewer,
            fn($q) => $q->forGuest(),
            fn($q) => $q->forUser($viewer)->excludeBlocked($viewer)
        );
    }

    /**
     * For guest users
     */
    public function scopeForGuest(Builder $query): Builder
    {
        return $query->where('status', 'public');
    }

    /**
     * For authenticated users
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where(function ($q) use ($user) {
            $q->where('status', 'public')
                ->orWhere(function ($q) use ($user) {
                    $q->where('status', 'private')
                        ->whereHas('user.followers', fn($q) => $q->where('follower_id', $user->id));
                })
                ->orWhere('user_id', $user->id);
        });
    }

    /**
     * Exclude blocked content
     */
    public function scopeExcludeBlocked(Builder $query, User $user): Builder
    {
        return $query->whereDoesntHave('user', function ($q) use ($user) {
            $q->where(function ($q) use ($user) {
                $q->whereHas('blockedUsers', fn($q) => $q->where('blocked_user_id', $user->id))
                    ->orWhereHas('blockedByUsers', fn($q) => $q->where('user_id', $user->id));
            });
        });
    }
}
