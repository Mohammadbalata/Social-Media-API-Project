<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    public function searchUser($search) : Builder
    {
        $query = User::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function update($user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function findById($userId): User
    {
        return User::find($userId);
    }

    public function followUser($authUser, $user): void
    {
        $authUser->following()->attach($user);
    }

    public function unfollowUser($authUser, $user): void
    {
        $authUser->following()->detach($user);
    }


    public function blockUser($authUser, $user)
    {
        return $authUser->blockedUsers()->attach($user);
    }

    public function unblockUser($authUser, $user)
    {
        return $authUser->blockedUsers()->detach($user);
    }

}
