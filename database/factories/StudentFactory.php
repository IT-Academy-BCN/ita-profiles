<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'user_id' => User::factory()->create()->id,
            'subtitle' => $this->faker->sentence,

            'bootcamp' => $this->faker->randomElement(['front end Developer', 'php developer', 'java developer', 'nodejs developer', 'data scientists']),

        ];
    }
}
