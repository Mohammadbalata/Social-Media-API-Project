<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct(protected UserService $service) {}

    public function getUserProfileById(User $user)
    {
        return $this->service->getUserProfileById($user);
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        return $this->service->updateUser($request, $user);
    }

    public function getUserPosts(User $user)
    {
        return $this->service->getUserPosts($user);
    }

    public function generateBio(Request $request)
    {
        return $this->service->generateBio($request);
    }
}
