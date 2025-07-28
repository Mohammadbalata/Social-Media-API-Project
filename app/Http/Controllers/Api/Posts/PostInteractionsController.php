<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;

/**
 * @OA\Post(
 *     path="/posts/{post}/like",
 *     operationId="likePost",
 *     tags={"Posts"},
 *     summary="Like a post",
 *     description="Add a like to a post",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="post",
 *         in="path",
 *         required=true,
 *         description="Post ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post liked successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Post liked successfully"),
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
 *     path="/posts/{post}/unlike",
 *     operationId="unlikePost",
 *     tags={"Posts"},
 *     summary="Unlike a post",
 *     description="Remove a like from a post",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="post",
 *         in="path",
 *         required=true,
 *         description="Post ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post unliked successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Post unliked successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Not liked",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/posts/{post}/pin",
 *     operationId="pinPost",
 *     tags={"Posts"},
 *     summary="Pin a post",
 *     description="Pin a post to the top of user's profile",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="post",
 *         in="path",
 *         required=true,
 *         description="Post ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post pinned successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Post pinned successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/posts/{post}/unpin",
 *     operationId="unpinPost",
 *     tags={"Posts"},
 *     summary="Unpin a post",
 *     description="Unpin a post from the top of user's profile",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="post",
 *         in="path",
 *         required=true,
 *         description="Post ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post unpinned successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Post unpinned successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */
class PostInteractionsController extends Controller
{

    public function __construct(protected PostService $service) {}

    public function likePost(Post $post)
    {
        return $this->service->likePost($post);
    }

    public function unlikePost(Post $post)
    {
        return $this->service->unlikePost($post);
    }

    public function pinPost(Post $post)
    {
        return $this->service->pinPost($post);
    }
    public function unpinPost(Post $post)
    {
        return $this->service->unpinPost($post);
    }

}
