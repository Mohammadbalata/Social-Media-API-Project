<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/users/{user}",
 *     operationId="getUserProfileById",
 *     tags={"Users"},
 *     summary="Get user profile",
 *     description="Retrieve a user's profile information",
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User profile retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User profile retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Put(
 *     path="/users/{user}",
 *     operationId="updateUser",
 *     tags={"Users"},
 *     summary="Update user profile",
 *     description="Update user's profile information",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/UpdateUserRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User profile updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User profile updated successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/User")
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
 *     path="/users/{user}/posts",
 *     operationId="getUserPosts",
 *     tags={"Users"},
 *     summary="Get user posts",
 *     description="Retrieve all posts by a specific user",
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="User ID",
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
 *         description="User posts retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User posts retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/users/generate-bio",
 *     operationId="generateBio",
 *     tags={"Users"},
 *     summary="Generate user bio",
 *     description="Generate a bio using AI",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="prompt",
 *         in="query",
 *         required=false,
 *         description="Bio generation prompt",
 *         @OA\Schema(type="string", example="Software developer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Bio generated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Bio generated successfully"),
 *             @OA\Property(property="data", type="object", @OA\Property(property="bio", type="string"))
 *         )
 *     )
 * )
 */
class UsersController extends Controller
{

    public function __construct(protected UserService $service) {}

    public function getUserProfileById(User $user)
    {
        return $this->service->getUserProfileById($user);
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        return $this->service->updateUser($request, $user);
    }

    public function getUserPosts(User $user)
    {
        return $this->service->getUserPosts($user);
    }

    public function generateBio(Request $request)
    {
        return $this->service->generateBio($request);
    }
}
