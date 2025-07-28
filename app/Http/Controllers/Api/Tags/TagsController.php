<?php

namespace App\Http\Controllers\Api\Tags;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/tags",
 *     operationId="getTags",
 *     tags={"Tags"},
 *     summary="Get all tags",
 *     description="Retrieve all available tags",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         description="Page number for pagination",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tags retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Tags retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/tags/{tag}/posts",
 *     operationId="getTagPosts",
 *     tags={"Tags"},
 *     summary="Get posts by tag",
 *     description="Retrieve all posts that contain a specific tag",
 *     @OA\Parameter(
 *         name="tag",
 *         in="path",
 *         required=true,
 *         description="Tag ID",
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
 *         description="Tag posts retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Tag posts retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/tags/{tag}/comments",
 *     operationId="getTagComments",
 *     tags={"Tags"},
 *     summary="Get comments by tag",
 *     description="Retrieve all comments that contain a specific tag",
 *     @OA\Parameter(
 *         name="tag",
 *         in="path",
 *         required=true,
 *         description="Tag ID",
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
 *         description="Tag comments retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Tag comments retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Pagination")
 *         )
 *     )
 * )
 */
class TagsController extends Controller
{
    public function __construct(
        protected TagService $tagService
    ) {
    }

    public function getTags(Request $request)
    {
        return $this->tagService->getTags();
    }

    public function getTagPosts(Tag $tag) 
    {
        return $this->tagService->getTagPosts($tag);
        
    }

    public function getTagComments(Tag $tag) 
    {
        return $this->tagService->getTagComments($tag);
        
    }
}
