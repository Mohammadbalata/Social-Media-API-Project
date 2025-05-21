<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use Searchable;
    protected $fillable = ['name'];
    public $timestamps = true;
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class, 'taggable');
    }

    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
