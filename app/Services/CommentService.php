<?php

namespace App\Services;

use App\Constants\CommentConstants;
use App\Events\CommentCreated;
use App\Events\ModelLiked;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Repositories\CommentRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
 
class CommentService extends BaseService
{
    public function __construct(protected MediaService $mediaService, protected CommentRepository $commentRepo) {}


    public function addCommentToPost($request, $post)
    {
        $user = Auth::user();
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
        ]);

        if ($request->has('media')) {
            $uplode = $this->mediaService->handleMediaUpload($request->file('media'), $comment);
        }
        CommentCreated::dispatch($user, $comment);

        $comment->load('media','mentionedUsers:id,username');
        $comment->loadCount('likes');
        
        return response()->json([
            'message' => CommentConstants::COMMENT_CREATE_MESSAGE,
            'data' => CommentResource::make($comment)
        ], 201);
       
    }

    public function getPostComments($post)
    {
        $comments = $post->comments()->paginate(8);
        
        return CommentResource::collection($comments);

    }

    public function updateComment($request, $comment)
    {
        $user = Auth::user();
        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $comment->update($request->validated());
        $comment->load('media','replies');
        return response()->json([
            'message' => CommentConstants::COMMENT_UPDATE_MESSAGE,
            'data' => CommentResource::make($comment)
        ], 200);

    }

    public function deleteComment($comment)
    {
        $user = Auth::user();
        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $comment->delete();
       
        return response()->json([
            'message' => CommentConstants::COMMENT_DESTROY_MESSAGE,
        ], 200);
    }

    public function getComment($comment)
    {
        $comment->load('media','replies');

        return $this->success(
            CommentResource::make($comment),
            CommentConstants::COMMENTS_RETRIEVED_MESSAGE
        );
    }

    public function likeComment($comment)
    {

        $user = Auth::user();
        if ($comment->isLikedBy($user)) {

            return response()->json([
                'message' => CommentConstants::LIKED_COMMENT_ERROR,
            ], 400);
        }
        $comment->likedBy($user);
        ModelLiked::dispatch($user, $comment);

        return response()->json([
            'message' => CommentConstants::LIKED_COMMENT_MESSAGE,
            'likes_count' => $comment->fresh()->likes_count,
        ], 200);
        
    }

    public function unlikeComment($comment)
    {
        $user = Auth::user();
        if (! $comment->isLikedBy($user)) {
            return response()->json([
                'message' => CommentConstants::UNLIKED_COMMENT_ERROR,
            ], 400);
        }
        $comment->dislikedBy($user);
        return response()->json([
            'message' => CommentConstants::UNLIKED_COMMENT_MESSAGE,
            'likes_count' => $comment->fresh()->likes_count,
        ], 200);
    }

    public function replyToComment($request, $comment)
    {
        $user = Auth::user();
        $reply = $comment->comments()->create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
        ]);

        if ($request->has('media')) {
            $uplode = $this->mediaService->handleMediaUpload($request->file('media'), $reply);
        }
        CommentCreated::dispatch($user, $reply);

        return response()->json([
            'message' => CommentConstants::COMMENT_CREATE_MESSAGE,
            'data' => CommentResource::make($reply)
        ], 201);
    }
}
