<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resume>
 */
class ResumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'id' => $this->faker->uuid,
            'subtitle' => $this->faker->sentence,
            'specialization' => $this->faker->randomElement(['Frontend', 'Backend', 'Fullstack', 'Data Science', 'Not Set']),
            'github_url' => $this->faker->url,
            'linkedin_url' => $this->faker->url,
            'tags_ids' => json_encode($this->faker->randomElements(range(1, 10), 3)),
        ];

    }
}
