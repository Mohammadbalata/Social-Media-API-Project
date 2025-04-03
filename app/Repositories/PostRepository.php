<?php

namespace App\Repositories;


use App\Models\Post;
use App\Models\User;

class PostRepository
{

    public function getUserPosts(User $user)
    {
        return $user->posts;
    }

    public function getPosts()
    {
        return Post::paginate(10);
    }


    public function findById($id)
    {
        return Post::find($id);
    }


    public function create(User $user, array $data)
    {
        return $user->posts()->create($data);
    }


    public function update($post, array $data)
    {
        $post->update($data);
        return $post;
    }

    public function likePost($user,$post)
    {
        $post->likedBy($user);
    }

    public function unlikePost($user,$post)
    {
        $post->dislikedBy($user);
    }
}
