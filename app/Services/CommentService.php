<?php

namespace App\Services;

use App\Http\Resources\CommentResource;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function __construct(protected CommentRepository $commentRepo) {}


    public function addCommentToPost($request, $post)
    {
        $user = Auth::user();
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id'),
        ]);
        return response()->json([
            'message' => 'Comment added successfully.',
            'comment' => $comment,
        ], 201);
    }

    public function getPostComments($post)
    {
        $comments = $post->comments()->paginate(10);
        return CommentResource::collection($comments);
    }

    public function updateComment($request, $comment)
    {
        $user = Auth::user();
        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $comment->update($request->validated());
        return response()->json([
            'message' => 'Comment updated successfully.',
            'comment' => $comment,
        ], 200);
    }

    public function deleteComment($comment)
    {
        $user = Auth::user();
        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully.'], 200);
    }

    public function likeComment($comment)
    {
        
        $user = Auth::user();
        if ($comment->isLikedBy($user)) {
            return response()->json(['message' => 'You have already liked this comment.'], 400);
        }
        $comment->likedBy($user);
        return response()->json(['message' => 'Comment liked successfully.'], 200);
    }

    public function unlikeComment($comment)
    {
        $user = Auth::user();
        if (! $comment->isLikedBy($user)) {
            return response()->json(['message' => 'You have not liked this comment.'], 400);
        }
        $comment->dislikedBy($user);
        return response()->json(['message' => 'Comment unliked successfully.'], 200);
    }

    public function replyToComment($request, $comment)
    {
        $user = Auth::user();
        $reply = $comment->comments()->create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'parent_id' => $comment->id,
        ]);
        // $comment->replies()->save($reply);
        return response()->json([
            'message' => 'Reply added successfully.',
            'reply' => $reply,
        ], 201);
    }
}
