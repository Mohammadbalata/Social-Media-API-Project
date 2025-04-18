<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{

    public function findByUserName($username): ?User
    {
        return User::where('username', $username)->first();
    }

    public function findById($id): ?User
    {
        return User::find($id);
    }

    public function searchUser($search): Builder
    {
        return User::query()
            ->where('username', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->select('id', 'username', 'email', 'avatar', 'verified')
            ->paginate(10);
    }
}
