<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commentableType = $this->faker->randomElement([Post::class, Comment::class]);
        
        return [
            'user_id' => User::factory(),
            'content' => $this->faker->sentence(7),
            'commentable_id' => $commentableType === Post::class 
                ? Post::factory() 
                : Comment::factory(),
            'commentable_type' => $commentableType,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
