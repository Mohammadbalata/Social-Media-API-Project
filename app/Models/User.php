<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\CustomNotifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,
        HasFactory,
        Notifiable,
        Searchable,
        CustomNotifiable;
        

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'bio',
        'avatar',
        'website',
        'location',
        'birthdate',
        'gender',
        'is_private',
        'is_verified',
        'status',
        'last_seen',
        'email_verified_at',
    ];

    // protected $appends = ['followers_count', 'following_count'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }


    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    public function sentfollowRequests()
    {
        return $this->hasMany(FollowRequest::class, 'sender_id');
    }

    public function receivedFollowRequests()
    {
        return $this->hasMany(FollowRequest::class, 'receiver_id');
    }

    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id')
            ->withTimestamps();
    }

    public function blockedByUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'blocked_user_id', 'user_id')
            ->withTimestamps();
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('id', $user->id)->exists();
    }

    public function isBlockedBy(User $user): bool
    {
        return $this->blockedUsers()->where('id', $user->id)->exists();
    }

    public function getFcmTokensAttribute()
    {
        return $this->devices()->pluck('fcm_token')->toArray();
    }



    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
