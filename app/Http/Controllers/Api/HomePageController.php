<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\HomePageService;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/search",
 *     operationId="search",
 *     tags={"Feed"},
 *     summary="Search content",
 *     description="Search for posts, users, and comments",
 *     @OA\Parameter(
 *         name="q",
 *         in="query",
 *         required=true,
 *         description="Search query",
 *         @OA\Schema(type="string", example="technology")
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         required=false,
 *         description="Type of content to search (posts, users, comments)",
 *         @OA\Schema(type="string", enum={"posts", "users", "comments"}, example="posts")
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
 *         description="Search results retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Search results retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/posts",
 *     operationId="getFeed",
 *     tags={"Feed"},
 *     summary="Get feed",
 *     description="Retrieve the main feed with posts from followed users",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         description="Page number for pagination",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Feed retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Feed retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 */
class HomePageController extends Controller
{
    public function __construct(
        protected HomePageService $homeService,

    ) {}

    public function search(Request $request)
    {
        return $this->homeService->search($request);
    }


    public function getFeed()
    {
        return $this->homeService->getFeed();
    }
}
