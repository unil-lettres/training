<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrientationFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word().' '.$this->faker->randomNumber(5, false),
        ];
    }
}
