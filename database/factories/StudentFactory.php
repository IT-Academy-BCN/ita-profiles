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
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'subtitle' => $this->faker->sentence,
            'about' => $this->faker->paragraph,
            'cv' => $this->faker->word . '.pdf',
            'bootcamp' => $this->faker->randomElement(['front end Developer', 'php developer', 'java developer', 'nodejs developer', 'data scientists']),
            'end_date' => $this->faker->dateTimeThisYear,
            'linkedin' => $this->faker->url,
            'github' => $this->faker->url,

        ];
    }
}
