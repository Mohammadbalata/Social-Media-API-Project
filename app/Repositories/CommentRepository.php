<?php

namespace App\Repositories;


class CommentRepository
{

    


    public function likeComment($user,$comment)
    {
        $comment->likedBy($user);
    }

    public function unlikeComment($user,$comment)
    {
        $comment->dislikedBy($user);
    }

}
