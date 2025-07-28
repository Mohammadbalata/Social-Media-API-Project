<?php

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;

/**
 * @OA\Put(
 *     path="/comments/{comment}",
 *     operationId="updateComment",
 *     tags={"Comments"},
 *     summary="Update a comment",
 *     description="Update an existing comment",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="comment",
 *         in="path",
 *         required=true,
 *         description="Comment ID",
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
 *         response=200,
 *         description="Comment updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Comment updated successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Comment")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - User not authorized to update this comment",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/comments/{comment}",
 *     operationId="deleteComment",
 *     tags={"Comments"},
 *     summary="Delete a comment",
 *     description="Delete a comment (soft delete)",
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
 *         description="Comment deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Comment deleted successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - User not authorized to delete this comment",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Comment not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/comments/{comment}",
 *     operationId="getComment",
 *     tags={"Comments"},
 *     summary="Get a specific comment",
 *     description="Retrieve a specific comment by ID",
 *     @OA\Parameter(
 *         name="comment",
 *         in="path",
 *         required=true,
 *         description="Comment ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comment retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Comment retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Comment")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Comment not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
class CommentsController extends Controller
{
    public function __construct(protected CommentService $service) {}

    public function updateComment(CommentRequest $request,Comment $comment)
    {
        return $this->service->updateComment($request, $comment);
    }

    public function deleteComment(Comment $comment)
    {
        return $this->service->deleteComment($comment);
    }

    public function getComment(Comment $comment)
    {
        return $this->service->getComment($comment);
    }
}
