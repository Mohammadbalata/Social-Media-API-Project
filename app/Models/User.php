<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

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
        'profile_image',
        'website',
        'location',
        'birthdate',
        'gender',
        'is_private',
        'verified',
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
        ];
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
            ->select('id', 'username', 'email', 'profile_image', 'verified')
            ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
            ->select('id', 'username', 'email', 'profile_image', 'verified')
            ->withTimestamps();
    }

    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id')
            ->withTimestamps();
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('id', $user->id)->exists();
    }

    public function isBlocked(User $user): bool
    {
        return $this->blockedUsers()->where('id', $user->id)->exists();
    }
}
