<?php

namespace App\Repositories\Eloquent;


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

    public function searchUser($search)
    {
        return User::search($search);
    }
}
