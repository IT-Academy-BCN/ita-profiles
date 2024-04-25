<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BootcampFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
        ];
    }
}
