<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct(protected PostRepository $postRepo) {}


    public function createPost($request)
    {
        $user = $request->user();
        $post = $user->posts()->create($request->validated());

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

        $post->update($request->validated());
        return response()->json([
            'message' => 'Post Updated successfully.',
            'post' => $post ,
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
        $posts = Post::paginate(10);
        return PostResource::collection($posts);
    }

    public function getPost($post)
    {
        return new PostResource($post);
    }

    public function likePost($post)
    {
        $user = Auth::user();
        if ($post->isLikedBy($user)) {
            return response()->json(['message' => 'You have already liked this post.'], 400);
        }
        $post->likedBy($user);
        return response()->json(['message' => 'Post liked successfully.'], 200);
    }

    public function unlikePost($post)
    {
        $user = Auth::user();
        if (! $post->isLikedBy($user) ) {
            return response()->json(['message' => 'You have not liked this post.'], 400);
        }
        $post->dislikedBy($user);
        return response()->json(['message' => 'Post unliked successfully.'], 200);
    }

    
}
