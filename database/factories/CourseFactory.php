<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'code' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'credits' => $this->faker->randomDigit(),
            'difficulty' => $this->faker->randomElement(['easy', 'normal', 'hard']),
            'image' => $this->faker->imageUrl(),
            'origin' => $this->faker->randomElement(['Lebanese University', 'Personal', 'Other']),
            'semester' => $this->faker->randomDigit(),
        ];
    }
}
