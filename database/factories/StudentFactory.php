<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\ValueObjects\StudentStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'name' => fake()->firstName(),
                'surname' => fake()->lastName(),
                'photo' =>   fake()->url(),
                'status' => StudentStatus::ACTIVE,
                'user_id' => User::factory(),
            ];
    }
}
