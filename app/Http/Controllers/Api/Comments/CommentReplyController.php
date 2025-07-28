<?php

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;

/**
 * @OA\Post(
 *     path="/comments/{comment}/reply",
 *     operationId="replyToComment",
 *     tags={"Comments"},
 *     summary="Reply to a comment",
 *     description="Add a reply to a specific comment",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="comment",
 *         in="path",
 *         required=true,
 *         description="Comment ID to reply to",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/CommentRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Reply added successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=201),
 *             @OA\Property(property="message", type="string", example="Reply added successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Comment")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/comments/{comment}/replies",
 *     operationId="getCommentReplies",
 *     tags={"Comments"},
 *     summary="Get comment replies",
 *     description="Retrieve all replies to a specific comment",
 *     @OA\Parameter(
 *         name="comment",
 *         in="path",
 *         required=true,
 *         description="Comment ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         description="Page number for pagination",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Replies retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Replies retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 */
class CommentReplyController extends Controller
{
    public function __construct(protected CommentService $service) {}


    public function replyToComment(CommentRequest $request, Comment $comment)
    {
        return $this->service->replyToComment($request, $comment);
    }

    public function getCommentReplies(Comment $comment)
    {
        return $this->service->getCommentReplies($comment);
    }

}
