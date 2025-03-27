<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['video', 'image', 'pdf', 'link', 'code', 'markdown', 'other']),
            'url' => $this->faker->url(),
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
