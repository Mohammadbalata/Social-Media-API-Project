<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\DeepSeekService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

    public function generateBio(Request $request)
    {
        return $this->service->generateBio($request);
    }
}
