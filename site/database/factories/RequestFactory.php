<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Request;
use App\Models\Status;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->randomHtml(),
            'filling_date' => now(),
            'applicants' => $this->faker->name,
            'theme' => $this->faker->sentence(3),
            'deadline' => now()->addMonth(),
            'extras' => json_decode('{"doctoral_school":null,"fns":"1","doctoral_status":null,"doctoral_level":null,"tested_products":null,"teachers_nbr":"0","students_nbr":"0","action_type":"0"}', true),
            'status_admin' => $this->faker->randomElement(Request::$status),
            'type' => $this->faker->randomElement(Request::$type),
            'category_id' => Category::factory(),
            'status_id' => Status::factory(),
            'user_id' => User::factory(),
        ];
    }
}
