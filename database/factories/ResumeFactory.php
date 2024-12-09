<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Student;
use App\Models\AdditionalTraining;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;

class ResumeFactory extends Factory
{
    public const  SUBTITLES = [
        "Ingeniero de Software",
        "Full Stack developer en PHP",
        "Frontend developer React",
        "Backend developer Java",
        "Analista de Datos",
    ];

    public function definition(): array
    {
        $developmentOptions = ['Spring', 'Laravel', 'Angular', 'React', 'Not Set'];
        $development = $this->faker->randomElement($developmentOptions);

        // I THINK THIS CAN ALSO BE REMOVED, is not used.
        $additionalTrainingsIds = AdditionalTraining::factory()->count(2)->create()->pluck('id')->toArray();

        return [
            'student_id' => Student::factory()->create(),
            'subtitle' => $this->faker->randomElement(self::SUBTITLES),
            'linkedin_url' => 'https://linkedin.com/' . $this->faker->userName,
            'github_url' => 'https://github.com/' . $this->faker->unique()->userName,
            'specialization' => $this->faker->randomElement(
                ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'Not Set'],
            ),
            'development' => $development,
            'modality' => $this->faker->randomElements(['Presencial', 'Híbrid', 'Remot'], rand(1, 3)),
            'about' => $this->faker->paragraph,
        ];
    }

    public function specificSpecialization(string $specialization): Factory
    {
        return $this->state(function (array $attributes) use ($specialization) {
            return [
                'specialization' => $specialization,
            ];
        });
    }

    public function specificDevelopment($data): Factory
    {
        return $this->state(function (array $attributes) use ($data) {
            return [
                'development' => $data,
            ];
        });
    }
}
