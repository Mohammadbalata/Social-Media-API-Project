<?php

namespace App\Services;

use App\Constants\PostConstants;
use App\Events\ModelLiked;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Eloquent\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostService extends BaseService
{
    public function __construct(
        protected MediaService $mediaService,
        protected PostRepository $postRepository
    ) {}


    public function createPost(PostRequest $request)
    {
        $user = $request->user();
        $post = $user->posts()->create($request->validated());
        if ($request->has('media')) {
            $uplode = $this->mediaService->handleMediaUpload($request->file('media'), $post);
        }
        $post->load('media');
        return response()->json([
            'message' => PostConstants::POST_CREATE_MESSAGE,
            'data' => PostResource::make($post)
        ], 201);
    }

    public function updatePost($request, $post)
    {

        Gate::authorize('update', $post);

        $post->update($request->validated());
        $post->load([
            'media',
        ]);


        return response()->json([
            'message' => PostConstants::POST_UPDATE_MESSAGE,
            'data' => PostResource::make($post)
        ], 200);
    }

    public function deletePost($post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => PostConstants::POST_DESTROY_MESSAGE
        ], 200);
    }



    public function getPost($post)
    {
        $post->load([
            'media',
        ]);

        return response()->json([
            'post' => PostResource::make($post),
        ]);
    }

    public function likePost($post)
    {

        $user = Auth::user();
        if ($post->isLikedBy($user)) {
            return response()->json([
                'message' => PostConstants::LIKED_POST_ERROR,
            ], 400);
        }

        $post->likedBy($user);
        // Dispatch the event to notify the user about the new like
        ModelLiked::dispatch($user, $post);
        return response()->json([
            'message' => PostConstants::LIKED_POST_MESSAGE,
            'likes_count' => $post->fresh()->likes_count
        ], 200);
    }

    public function unlikePost($post)
    {
        $user = Auth::user();
        if (! $post->isLikedBy($user)) {
            return response()->json([
                'message' => PostConstants::UNLIKED_POST_ERROR,
            ], 400);
        }
        $post->dislikedBy($user);

        return response()->json([
            'message' => PostConstants::UNLIKED_POST_MESSAGE,
            'likes_count' => $post->fresh()->likes_count
        ], 200);
    }
    public function pinPost($post)
    {
        $post->is_pinned = true;
        $post->save();
        return response()->json([
            'message' => PostConstants::POST_PINNED_MESSAGE,
        ], 200);
    }

    public function unpinPost($post)
    {
        $post->is_pinned = false;
        $post->save();
        return response()->json([
            'message' => PostConstants::POST_UNPINNED_MESSAGE,
        ], 200);
    }
}
