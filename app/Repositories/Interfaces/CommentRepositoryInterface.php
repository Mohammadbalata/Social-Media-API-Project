<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\Comment;
use App\Models\Post;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    public function likeComment(User $user, Comment $comment);
    public function unlikeComment(User $user, Comment $comment);
}