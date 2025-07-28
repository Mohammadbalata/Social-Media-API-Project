<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getPostFeed(null | User  $user, int $limit = 10)
    {
         

        return Post::visibleTo($user)->with([
                'media','likes'
            ])->oldest('id')->paginate($limit);
    }
}
