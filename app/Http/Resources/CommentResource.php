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
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'avatar' => $this->user->avatar,
                'is_verified' => $this->user->is_verified
            ],
            'content' => $this->content,
            'parent_id' => $this->parent_id,
            'likes_count' => $this->whenCounted('likes'),
            'replies_count' => $this->whenCounted('replies'),
            'likers' => $this->whenLoaded('likers'),
            'mentions' => $this->whenLoaded('mentionedUsers'),
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
