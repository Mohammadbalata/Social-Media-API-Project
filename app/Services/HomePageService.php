<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Repositories\Eloquent\PostRepository;
use Illuminate\Support\Facades\Auth;

class HomePageService extends BaseService
{
    public function __construct(
        protected PostRepository $postRepository,
    ) {}

    public function search($request)
    {
        $searchQuery = $request->input('query');

        $userQuery = User::search($searchQuery);
        $users = $userQuery->paginate(10);

        $postQuery = Post::search($searchQuery);
        $posts = $postQuery->paginate(10);

        $tagQuery = Tag::search($searchQuery);
        $tags = $tagQuery->paginate(10);

        return response()->json(
            [
                'query' => $searchQuery,
                'users' => UserResource::collection($users),
                'posts' => PostResource::collection($posts),
                'tags' => TagResource::collection($tags),
            ],
            200
        );
    }

    public function getFeed()
    {
        $user  = Auth::guard('sanctum')->user();

        $posts = $this->postRepository->getPostFeed($user);

        return PostResource::collection($posts);
    }
}
