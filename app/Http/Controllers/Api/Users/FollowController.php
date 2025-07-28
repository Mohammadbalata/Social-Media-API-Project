<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

/**
 * @OA\Get(
 *     path="/users/{user}/followers",
 *     operationId="getUserFollowers",
 *     tags={"Users"},
 *     summary="Get user followers",
 *     description="Retrieve all followers of a specific user",
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
 *         description="Followers retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Followers retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/users/{user}/following",
 *     operationId="getUserFollowing",
 *     tags={"Users"},
 *     summary="Get user following",
 *     description="Retrieve all users that a specific user is following",
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
 *         description="Following retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Following retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/users/{user}/follow",
 *     operationId="followUser",
 *     tags={"Users"},
 *     summary="Follow a user",
 *     description="Start following a specific user",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="User ID to follow",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User followed successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User followed successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Already following or cannot follow yourself",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/users/{user}/unfollow",
 *     operationId="unfollowUser",
 *     tags={"Users"},
 *     summary="Unfollow a user",
 *     description="Stop following a specific user",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="User ID to unfollow",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User unfollowed successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User unfollowed successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Not following this user",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
class FollowController extends Controller
{

    public function __construct(protected UserService $service) {}

    

    public function getUserFollowers(User $user)
    {
        return $this->service->getUserFollowers($user);
    }

    public function getUserFollowing(User $user)
    {
        return $this->service->getUserFollowing($user);
    }

    public function followUser(User $user){
        return $this->service->followUser($user);
    }

    public function unfollowUser(User $user){
        return $this->service->unfollowUser($user);

    }

    

}
