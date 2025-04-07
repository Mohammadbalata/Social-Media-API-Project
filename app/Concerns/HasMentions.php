<?php

namespace App\Concerns;

use App\Models\Mention;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasMentions
{
    public static function bootHasMentions()
    {
        static::saved(function ($model) {
            $model->extractAndStoreMentions();
        });

        static::deleting(function ($model) {
            $model->mentions()->delete();
        });
    }

    public function mentions()
    {
        return $this->morphMany(Mention::class, 'mentionable');
    }

    public function extractAndStoreMentions()
    {
        $content = $this->content ?? '';
        preg_match_all('/@([\w_]+)/', $content, $matches);

        $usernames = $matches[1] ?? [];

        $users = User::whereIn('username', $usernames)->get();

        $this->mentions()->delete();

        foreach ($users as $user) {
            $this->mentions()->create([
                'user_id' => $user->id,
            ]);
        }
    }

    public function mentionedUsers()
    {
        return $this->belongsToMany(User::class, Mention::class, 'mentionable_id')
            ->where('mentionable_type', array_search(static::class, Relation::morphMap()) ?: static::class)
            ->select('user_id', 'username', 'email');
        
        
    }
}
