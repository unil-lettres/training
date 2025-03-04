<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'roles' => [strtolower(UserRole::ADMIN->name)],
            ];
        });
    }

    /**
     * Indicate that the user is a super editor.
     */
    public function superEditor(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'roles' => [strtolower(UserRole::SUPER_EDITOR->name)],
            ];
        });
    }
}
