<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResumeFactory extends Factory
{
    public function definition(): array
    {
        $subtitle = $this->faker->randomElement([
            'Ingeniero de Software',
            'Full Stack developer en PHP',
            'Frontend developer React',
            'Backend developer Java',
            'Analista de Datos'
        ]);

        $specialization = $this->faker->randomElement([
            'Frontend',
            'Backend',
            'Fullstack',
            'Data Science',
            'Not Set'
        ]);

        $development = $this->faker->randomElement([
            'Spring',
            'Laravel',
            'Angular',
            'React',
            'Not Set'
        ]);

        $modality = $this->faker->randomElements([
            'Presencial',
            'Híbrid',
            'Remot',
        ], rand(1, 3));

        return [
            'student_id' => Student::factory()->create(),
            'subtitle' => $subtitle,
            'linkedin_url' => 'https://linkedin.com/' . $this->faker->userName,
            'github_url' => 'https://github.com/' . $this->faker->unique()->userName,
            'specialization' => $specialization,
            'development' => $development,
            'modality' => $modality,
            'about' => $this->faker->paragraph,
        ];
    }
}
