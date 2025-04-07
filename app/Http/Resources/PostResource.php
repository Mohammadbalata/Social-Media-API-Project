<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'user' => $this->user,
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'privacy' => $this->privacy,
            'is_pinned' => $this->is_pinned,
            'is_deleted' => $this->is_deleted,
            'likes' => $this->likes,
            'shares' => $this->shares,
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'likers' => $this->likers,
            'mentioned_users' => $this->mentionedUsers,
            'comments' => CommentResource::collection($this->comments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
