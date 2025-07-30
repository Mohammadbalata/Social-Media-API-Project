<?php

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;

class CommentsController extends Controller
{
    public function __construct(protected CommentService $service) {}

    public function updateComment(CommentRequest $request,Comment $comment)
    {
        return $this->service->updateComment($request, $comment);
    }

    public function deleteComment(Comment $comment)
    {
        return $this->service->deleteComment($comment);
    }

    public function getComment(Comment $comment)
    {
        return $this->service->getComment($comment);
    }
}
