<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

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


    public function getAllPosts()
    {
        return $this->service->getAllPosts();
    }

    public function getPost(Post $post)
    {
        return $this->service->getPost($post);
    }

    public function deletePost(Post $post)
    {
        return $this->service->deletePost($post);
    }

    public function likePost(Post $post)
    {
        return $this->service->likePost($post);
    }

    public function unlikePost(Post $post)
    {
        return $this->service->unlikePost($post);
    }

}
