<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'user' => $this->whenLoaded('user', function () {
                return (new UserResource($this->user))->serializeForList();
            }),
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'status' => $this->status,
            'is_pinned' => $this->is_pinned,
            'is_deleted' => $this->is_deleted,
            'shares' => $this->shares,
            'likes_count' => $this->whenCounted('likes'),
            'comments_count' => $this->whenCounted('allComments'),
            'likers' => $this->whenLoaded('likers', function () {
                return $this->likers->map(function ($user) {
                    return (new UserResource($user))->serializeForList();
                });
            }),
            'mentions' => $this->whenLoaded('mentionedUsers', function () {
                return $this->mentionedUsers->map(function ($user) {
                    return (new UserResource($user))->serializeForList();
                });
            }),

            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'is_liked' => $this->whenLoaded('likes', function () {
                return $this->likes->where('user_id', Auth::guard('sanctum')->id())->isNotEmpty();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }



   
}
