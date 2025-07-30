<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;

class PostInteractionsController extends Controller
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

    public function pinPost(Post $post)
    {
        return $this->service->pinPost($post);
    }
    public function unpinPost(Post $post)
    {
        return $this->service->unpinPost($post);
    }

}
