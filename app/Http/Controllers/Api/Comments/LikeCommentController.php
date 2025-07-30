<?php

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;

class LikeCommentController extends Controller
{
    public function __construct(protected CommentService $service) {}

    public function likeComment(Comment $comment)
    {
        return $this->service->likeComment($comment);
    }

    public function unlikeComment(Comment $comment)
    {
        return $this->service->unlikeComment($comment);
    }
}
