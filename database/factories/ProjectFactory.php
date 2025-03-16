<?php

namespace Database\Factories;

use App\Models\Project;
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
            'image_url' => 'project-images/' . $this->faker->image('public/storage/project-images', 640, 480, null, false),
            'github_url' => $this->faker->url(),
            'live_url' => $this->faker->url(),
            'type' => $this->faker->randomElement(['mini', 'personal', 'corporate']),
        ];
    }
}
