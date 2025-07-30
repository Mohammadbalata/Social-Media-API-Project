<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

class BlockController extends Controller
{
    public function __construct(protected UserService $service) {}

    public function blockUser(User $user)
    {
        return $this->service->blockUser($user);
    }

    public function unblockUser(User $user)
    {
        return $this->service->unblockUser($user);
    }
}
