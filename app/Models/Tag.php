<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
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
}
