<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Default password is 'password'
            'bio' => $this->faker->optional()->sentence,
            'avatar' => $this->faker->optional()->imageUrl(200, 200, 'people'),
            'website' => $this->faker->optional()->url,
            'location' => $this->faker->optional()->city,
            'birthdate' => $this->faker->optional()->date(),
            'gender' => $this->faker->optional()->randomElement(['male', 'female', 'other']),
            'is_private' => $this->faker->boolean(20), // 20% chance of being true
            'verified' => $this->faker->boolean(70), // 70% chance of being true
            'status' => $this->faker->randomElement(['active', 'suspended', 'deleted']),
            'last_seen' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'email_verified_at' => $this->faker->optional(70)->dateTimeBetween('-1 year', 'now'), // 70% chance of being verified
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
