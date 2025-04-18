<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Services\CommentService;

class PostCommentController extends Controller
{

    public function __construct(protected CommentService $service) {}

    public function addCommentToPost(CommentRequest $request,Post $post)
    {
        return $this->service->addCommentToPost($request,$post);
    }

    public function getPostComments(Post $post)
    {
        return $this->service->getPostComments($post);
    }
}