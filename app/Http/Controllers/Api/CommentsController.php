<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;

class CommentsController extends Controller
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

    public function updateComment(CommentRequest $request,Comment $comment)
    {
        return $this->service->updateComment($request, $comment);
    }

    public function deleteComment(Comment $comment)
    {
        return $this->service->deleteComment($comment);
    }

    public function likeComment(Comment $comment)
    {
        return $this->service->likeComment($comment);
    }

    public function unlikeComment(Comment $comment)
    {
        return $this->service->unlikeComment($comment);
    }

    public function replyToComment(CommentRequest $request, Comment $comment)
    {
        return $this->service->replyToComment($request, $comment);
    }

}
