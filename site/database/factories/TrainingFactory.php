<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->randomHtml,
            'start' => now()->addDay(),
            'end' => now()->addWeek(),
            'visible' => true,
        ];
    }
}
