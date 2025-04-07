<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\Post;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function likePost(User $user, Post $post);
    public function unlikePost(User $user, Post $post);
    public function getPosts();
}