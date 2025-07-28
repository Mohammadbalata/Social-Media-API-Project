<?php

namespace App\Services;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Tag;

class TagService extends BaseService
{

    public function getTags()
    {
        return Tag::paginate(10);
    }

    public function getTagPosts($tag)
    {
        return PostResource::collection($tag->posts()->paginate(10));
    }

    public function getTagComments($tag)
    {
        return CommentResource::collection($tag->comments()->paginate(10));
    }


    


    
}
