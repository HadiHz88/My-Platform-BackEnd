<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(3, true),
            'image_url' => $this->faker->imageUrl(),
        ];
    }

    public function configure(): BlogFactory|Factory
    {
        return $this->afterCreating(function (Blog $blog) {
            // Attach random tags (1 to 3 per blog)
            $tags = Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $blog->tags()->attach($tags);
        });
    }
}
