<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
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
            'description' => $this->faker->paragraph,
            'organization' => $this->faker->company,
            'location' => $this->faker->city,
            'type' => $this->faker->randomElement(['experience', 'education']),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
        ];
    }
}
