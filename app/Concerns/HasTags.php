<?php

namespace App\Concerns;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    protected static function bootHasTags(): void
    {
        static::saved(function ($model) {
            $model->extractAndStoreTags();
        });
        static::deleting(function ($model) {
            $model->tags()->detach();
            $model->unsetRelation('tags');
        });
    }


    public function extractAndStoreTags(): void
    {
        $content = $this->content ?? '';
        preg_match_all('/#([\w_]+)/', $content, $matches);

        $tagNames = $matches[1] ?? [];

        $tags = collect($tagNames)->map(function ($tagName) {
            return Tag::firstOrCreate(['name' => strtolower($tagName)]);
        });

        $this->tags()->detach();

        $this->tags()->sync($tags->pluck('id'));

        $this->unsetRelation('tags');
    }


    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')
            ->withTimestamps();
    }

    public function hasTag(string $name): bool
    {
        return $this->tags()->where('name', strtolower($name))->exists();
    }
}
