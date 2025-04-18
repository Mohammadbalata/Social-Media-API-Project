<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PostService;
use App\Services\UserService;

class HomeController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected PostService $postService

        ) {}

    public function getFeed()
    {
        return $this->postService->getFeed();
    }


   
}
