<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowRequestResource extends JsonResource
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
            'sender' => $this->whenLoaded('sender', function () {
                return (new UserResource($this->sender))->serializeForList();
            }),
            'receiver' => $this->whenLoaded('receiver', function () {
                return (new UserResource($this->receiver))->serializeForList();
            }),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
