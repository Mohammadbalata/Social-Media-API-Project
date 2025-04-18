<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;

class LikePostController extends Controller
{

    public function __construct(protected PostService $service) {}

    public function likePost(Post $post)
    {
        return $this->service->likePost($post);
    }

    public function unlikePost(Post $post)
    {
        return $this->service->unlikePost($post);
    }

}
