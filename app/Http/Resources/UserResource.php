<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'profile_image' => $this->profile_image,
            'email' => $this->email,
            'bio' => $this->bio,
            'website' => $this->website,
            'location' => $this->location,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'is_private' => $this->is_private,
            "verified" =>  $this->verified,
            "status" => $this->status,
            "last_seen" =>  $this->last_seen,
            "email_verified_at" =>  $this->email_verified_at,
            'followers_count' => $this->followers_count,
            'following_count' => $this->following_count,
            'following' => $this->following,
            'followers' => $this->followers,
            'posts' => PostResource::collection($this->posts),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
