<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->company(),
            'email' => $faker->unique()->safeEmail(),
            'CIF' => $faker->unique()->regexify('[1-9]{8}[A-Z]'),
            'location' => $faker->address(),
            'website' => $faker->url()
        ];
    }
}
