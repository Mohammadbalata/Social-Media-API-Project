<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'parent_id' => $this->parent_id,
            'likes_count' => $this->likes_count,
            'likers' => $this->likers,
            'replies' => CommentResource::collection($this->replies),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
