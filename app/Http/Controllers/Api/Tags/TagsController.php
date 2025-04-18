<?php

namespace App\Http\Controllers\Api\Tags;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

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
