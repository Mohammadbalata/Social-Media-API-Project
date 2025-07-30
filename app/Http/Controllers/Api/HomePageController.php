<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\HomePageService;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function __construct(
        protected HomePageService $homeService,

    ) {}

    public function search(Request $request)
    {
        return $this->homeService->search($request);
    }


    public function getFeed()
    {
        return $this->homeService->getFeed();
    }
}
