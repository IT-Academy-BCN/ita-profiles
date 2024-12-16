<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'username' => $this->faker->userName(),
            'dni' => $this->generateFakeDniOrNie(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    function generateFakeDniOrNie(): string
    {
        if (rand(1, 10) === 1) {
            return $this->generateFakeNie();
        }
        return $this->generateFakeDni();
    }

    function generateFakeDni(): string
    {
        $numbers = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $letter = $letters[$numbers % 23];
        return $numbers . $letter;
    }

    function generateFakeNie(): string
    {
        $prefixes = ['X', 'Y', 'Z'];
        $prefix = $prefixes[array_rand($prefixes)];
        $numbers = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';

        $numericPrefix = str_replace(['X', 'Y', 'Z'], [0, 1, 2], $prefix);
        $fullNumber = $numericPrefix . $numbers;
        $letter = $letters[$fullNumber % 23];
        return $prefix . $numbers . $letter;
    }
}
