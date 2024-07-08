<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\ValueObjects\StudentStatus;
use App\Models\Student;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Student::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'id' => fake()->uuid(),
                'name' => fake()->regexify('[A-Za-z]{5,10}'),
                'surname' => fake()->regexify('[A-Za-z]{5,10}'),
                'photo' =>   fake()->url(),
                'status' => StudentStatus::ACTIVE,
            ];
    }
}
