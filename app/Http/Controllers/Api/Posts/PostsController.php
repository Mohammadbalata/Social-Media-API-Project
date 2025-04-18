<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;

class PostsController extends Controller
{

    public function __construct(protected PostService $service) {}

    public function createPost(PostRequest $request)
    {
        return $this->service->createPost($request);
    }

    public function updatePost(PostRequest $request, Post $post)
    {
        return $this->service->updatePost($request, $post);
    }


    public function getPost(Post $post)
    {
        return $this->service->getPost($post);
    }

    public function deletePost(Post $post)
    {
        return $this->service->deletePost($post);
    }
}
