<?php

namespace App\Concerns;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedia
{

    protected static function bootHasMedia(): void
    {
        static::deleting(function ($model) {
            $model->media()->delete();
            $model->unsetRelation('media');
        });
    }
   
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function clearMedia(): void
    {
        $this->media()->delete();
    }
}