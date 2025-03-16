<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => $this->faker->word(),
            'icon'  => $this->faker->randomElement(['fas fa-code', 'fas fa-database', 'fas fa-mobile-alt']),
            'color' => $this->faker->hexColor(),
        ];
    }
}
