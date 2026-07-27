<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(3, 8));
        $publishedAt = fake()->optional(0.7)->dateTimeBetween('-1 year', 'now');
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => fake()->paragraphs(rand(5, 15), true),
            'featured_image' => fake()->optional(0.6)->imageUrl(800, 400, 'technology'),
            'user_id' => User::factory(),
            'category_id' => fake()->numberBetween(1, 4),
            'status_id' => fake()->numberBetween(1, 4),
            'published_at' => $publishedAt,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_id' => 2,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_id' => 1,
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_id' => 3,
            'published_at' => fake()->dateTimeBetween('now', '+3 months'),
        ]);
    }
}
