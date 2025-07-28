<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ExcludeBlockedUsersScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = authUser();

        if (!$user) return;

        $blockedUserIds = $user->blockedUsers()->pluck('users.id')->merge(
            $user->blockedByUsers()->pluck('users.id')
        );

        $builder->whereNotIn('user_id', $blockedUserIds);
    }
}


