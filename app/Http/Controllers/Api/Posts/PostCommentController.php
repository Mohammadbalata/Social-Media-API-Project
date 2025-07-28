<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Services\CommentService;

/**
 * @OA\Post(
 *     path="/posts/{post}/comments",
 *     operationId="addCommentToPost",
 *     tags={"Posts"},
 *     summary="Add comment to post",
 *     description="Add a new comment to a specific post",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="post",
 *         in="path",
 *         required=true,
 *         description="Post ID",
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
 *         description="Comment added successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=201),
 *             @OA\Property(property="message", type="string", example="Comment added successfully"),
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
 *     path="/posts/{post}/comments",
 *     operationId="getPostComments",
 *     tags={"Posts"},
 *     summary="Get post comments",
 *     description="Retrieve all comments for a specific post",
 *     @OA\Parameter(
 *         name="post",
 *         in="path",
 *         required=true,
 *         description="Post ID",
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
 *         description="Comments retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Comments retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 */
class PostCommentController extends Controller
{

    public function __construct(protected CommentService $service) {}

    public function addCommentToPost(CommentRequest $request,Post $post)
    {
        return $this->service->addCommentToPost($request,$post);
    }

    public function getPostComments(Post $post)
    {
        return $this->service->getPostComments($post);
    }
}