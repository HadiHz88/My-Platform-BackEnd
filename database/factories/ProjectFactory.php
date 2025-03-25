<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(3, true),
            'image_url' => $this->faker->imageUrl(),
            'github_url' => $this->faker->url(),
            'live_url' => $this->faker->url(),
            'type' => $this->faker->randomElement(['mini', 'personal', 'corporate']),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }

    public function configure(): ProjectFactory
    {
        return $this->afterCreating(function (Project $project) {
            $tags = Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $project->tags()->attach($tags);
        });
    }
}
