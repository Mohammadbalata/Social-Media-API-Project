<?php

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;

class CommentReplyController extends Controller
{
    public function __construct(protected CommentService $service) {}


    public function replyToComment(CommentRequest $request, Comment $comment)
    {
        return $this->service->replyToComment($request, $comment);
    }

    public function getCommentReplies(Comment $comment)
    {
        return $this->service->getCommentReplies($comment);
    }

}
