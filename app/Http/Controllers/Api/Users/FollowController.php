<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

class FollowController extends Controller
{

    public function __construct(protected UserService $service) {}

    

    public function getUserFollowers(User $user)
    {
        return $this->service->getUserFollowers($user);
    }

    public function getUserFollowing(User $user)
    {
        return $this->service->getUserFollowing($user);
    }

    public function followUser(User $user){
        return $this->service->followUser($user);
    }

    public function unfollowUser(User $user){
        return $this->service->unfollowUser($user);

    }

    

}
