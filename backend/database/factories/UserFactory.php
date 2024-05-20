<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => fake()->numberBetween(10000000000, 99999999999),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'course' => fake()->randomElement(['BSIS', 'BSCS', 'BSIT']),
            'year_level' => fake()->randomElement(['1st Year', '2nd Year', '3rd Year', '4th Year']),
            'section' => fake()->randomElement(['1', '2', '3']),
            'email' => fake()->unique()->safeEmail(), 
            'is_admin' => fake()->randomElement([true, false]),
        ];
    }

    // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    // public function unverified(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }
}
