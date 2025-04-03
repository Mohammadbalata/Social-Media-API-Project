<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct(protected PostRepository $postRepo) {}


    public function createPost($request)
    {
        $user = $request->user();
        $post = $this->postRepo->create($user, $request->validated());
        return response()->json([
            'message' => 'Post created successfully.',
            'post' => $post,
        ], 201);
    }

    public function updatePost($request, $post)
    {

        $user = $request->user();
        if ($post->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return response()->json([
            'message' => 'Post Updated successfully.',
            'post' => $this->postRepo->update($post, $request->validated()),
        ], 200);
    }
    public function deletePost($post)
    {
        $user = Auth::user();
        if ($post->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully.'], 200);
    }


    public function getAllPosts()
    {
        $posts = $this->postRepo->getPosts();
        return response()->json($posts, 200);
    }

    public function getPost($post)
    {
        return response()->json($post, 200);
    }

    public function likePost($post)
    {
        $user = Auth::user();
        if ($post->isLikedBy($user)) {
            return response()->json(['message' => 'You have already liked this post.'], 400);
        }
        $this->postRepo->likePost($user, $post);
        return response()->json(['message' => 'Post liked successfully.'], 200);
    }

    public function unlikePost($post)
    {
        $user = Auth::user();
        if (! $post->isLikedBy($user) ) {
            return response()->json(['message' => 'You have not liked this post.'], 400);
        }
        $this->postRepo->unlikePost($user, $post);
        return response()->json(['message' => 'Post unliked successfully.'], 200);
    }

    
}
