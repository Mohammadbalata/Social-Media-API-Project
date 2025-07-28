<?php

namespace App\Services;

use App\Constants\PostConstants;
use App\Events\ModelLiked;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
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

        return jsonResponse(
            true,
            201,
            PostConstants::POST_CREATE_MESSAGE,
            ['data' => PostResource::make($post)]
        );
    }

    public function updatePost($request, $post)
    {

        Gate::authorize('update', $post);

        $post->update($request->validated());
        $post->load([
            'media',
        ]);

        return jsonResponse(
            true,
            200,
            PostConstants::POST_UPDATE_MESSAGE,
            ['data' => PostResource::make($post)]
        );
    }

    public function deletePost($post)
    {
        Gate::authorize('delete', $post);

        $post->delete();


        return jsonResponse(
            true,
            200,
            PostConstants::POST_DESTROY_MESSAGE,
        );
    }

    public function getPost($post)
    {
        $post->load([
            'user',
            'likes',
            'mentionedUsers:id,username',
            'media',
            'likers',
        ]);

        $post->loadCount([
            'likes',
            'allComments',
        ]);

        return jsonResponse(
            true,
            200,
            PostConstants::POST_RETRIEVED_MESSAGE,
            ['data' => PostResource::make($post)]
        );
    }

    public function likePost($post)
    {

        $user = Auth::user();
        if ($post->isLikedBy($user)) {
            return jsonResponse(
                false,
                400,
                PostConstants::LIKED_POST_ERROR,
            );
        }

        $post->likedBy($user);
        // Dispatch the event to notify the user about the new like
        ModelLiked::dispatch($user, $post);

        if ($post->user->id !== $user->id) {
            sendNotification(
                $post->user->fcm_tokens,
                'Someone Has liked Your Post',
                "@{$user->username} Liked Your Post",
                ['type' => 'post like', 'user_id' => $user->id]
            );
        }

        return jsonResponse(
            true,
            200,
            PostConstants::LIKED_POST_MESSAGE,
            ['likes_count' => $post->fresh()->likes_count]
        );
    }

    public function unlikePost($post)
    {
        $user = Auth::user();
        if (! $post->isLikedBy($user)) {
            return jsonResponse(
                false,
                400,
                PostConstants::UNLIKED_POST_ERROR,
            );
        }
        $post->dislikedBy($user);

        return jsonResponse(
            true,
            200,
            PostConstants::UNLIKED_POST_MESSAGE,
            ['likes_count' => $post->fresh()->likes_count]
        );
    }
    public function pinPost($post)
    {

        $user = authUser();
        if ($user->id !== $post->user_id) {
            return jsonResponse(
                false,
                403,
                PostConstants::UNAUTHORIZED_MESSAGE,
            );
        }

        $post->is_pinned = true;
        $post->save();
        return jsonResponse(
            true,
            200,
            PostConstants::POST_PINNED_MESSAGE,
        );
    }

    public function unpinPost($post)
    {
        $user = authUser();
        if ($user->id !== $post->user_id) {
            return jsonResponse(
                false,
                403,
                PostConstants::UNAUTHORIZED_MESSAGE,
            );
        }

        $post->is_pinned = false;
        $post->save();

        return jsonResponse(
            true,
            200,
            PostConstants::POST_UNPINNED_MESSAGE,
        );
    }
}
