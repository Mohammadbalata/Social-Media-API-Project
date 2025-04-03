<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct(protected UserService $service) {}

    public function searchUser(Request $request)
    {
        return $this->service->searchUser($request);
    }

    public function getUserData(User $user)
    {
        return $this->service->getUserData($user);
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        return $this->service->updateUser($request, $user);
    }

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

    public function blockUser(User $user){
        return $this->service->blockUser($user);
    }

    public function unblockUser(User $user){
        return $this->service->unblockUser($user);

    }
}
