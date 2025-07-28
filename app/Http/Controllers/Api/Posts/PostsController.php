<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;

/**
 * @OA\Post(
 *     path="/posts",
 *     operationId="createPost",
 *     tags={"Posts"},
 *     summary="Create a new post",
 *     description="Create a new post with optional media attachments",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/PostRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Post created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=201),
 *             @OA\Property(property="message", type="string", example="Post created successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Post")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Put(
 *     path="/posts/{post}",
 *     operationId="updatePost",
 *     tags={"Posts"},
 *     summary="Update a post",
 *     description="Update an existing post",
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
 *             @OA\Schema(ref="#/components/schemas/PostRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Post updated successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Post")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - User not authorized to update this post",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/posts/{post}",
 *     operationId="getPost",
 *     tags={"Posts"},
 *     summary="Get a specific post",
 *     description="Retrieve a specific post by ID",
 *     @OA\Parameter(
 *         name="post",
 *         in="path",
 *         required=true,
 *         description="Post ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Post retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Post")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/posts/{post}",
 *     operationId="deletePost",
 *     tags={"Posts"},
 *     summary="Delete a post",
 *     description="Delete a post (soft delete)",
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
 *         description="Post deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Post deleted successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - User not authorized to delete this post",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
class PostsController extends Controller
{

    public function __construct(protected PostService $service) {}
   
    public function createPost(PostRequest $request)
    {
        return $this->service->createPost($request);
    }

    public function updatePost(PostRequest $request, Post $post)
    {
        return $this->service->updatePost($request, $post);
    }


    public function getPost(Post $post)
    {
        return $this->service->getPost($post);
    }

    public function deletePost(Post $post)
    {
        return $this->service->deletePost($post);
    }
}
