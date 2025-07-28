<?php

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;

/**
 * @OA\Post(
 *     path="/comments/{comment}/like",
 *     operationId="likeComment",
 *     tags={"Comments"},
 *     summary="Like a comment",
 *     description="Add a like to a comment",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="comment",
 *         in="path",
 *         required=true,
 *         description="Comment ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comment liked successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Comment liked successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Already liked",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/comments/{comment}/unlike",
 *     operationId="unlikeComment",
 *     tags={"Comments"},
 *     summary="Unlike a comment",
 *     description="Remove a like from a comment",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="comment",
 *         in="path",
 *         required=true,
 *         description="Comment ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comment unliked successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Comment unliked successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Not liked",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
class LikeCommentController extends Controller
{
    public function __construct(protected CommentService $service) {}

    public function likeComment(Comment $comment)
    {
        return $this->service->likeComment($comment);
    }

    public function unlikeComment(Comment $comment)
    {
        return $this->service->unlikeComment($comment);
    }
}
