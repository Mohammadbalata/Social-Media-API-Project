<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

/**
 * @OA\Post(
 *     path="/users/{user}/block",
 *     operationId="blockUser",
 *     tags={"Users"},
 *     summary="Block a user",
 *     description="Block a specific user",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="User ID to block",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User blocked successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User blocked successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Cannot block yourself or already blocked",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/users/{user}/unblock",
 *     operationId="unblockUser",
 *     tags={"Users"},
 *     summary="Unblock a user",
 *     description="Unblock a specific user",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="User ID to unblock",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User unblocked successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User unblocked successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="User not blocked",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
class BlockController extends Controller
{
    public function __construct(protected UserService $service) {}

    public function blockUser(User $user)
    {
        return $this->service->blockUser($user);
    }

    public function unblockUser(User $user)
    {
        return $this->service->unblockUser($user);
    }
}
