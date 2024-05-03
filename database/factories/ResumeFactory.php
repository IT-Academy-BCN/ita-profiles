<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Student;
use App\Models\AdditionalTraining;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $tagsIds = json_encode($this->faker->randomElements((range(1, 26)), 4));
        $projectIds = Project::factory()->count(2)->create()->pluck('id')->toArray();
        $additionalTrainingsIds = AdditionalTraining::factory()->count(2)->create()->pluck('id')->toArray();
        return [
            'student_id' =>  Student::factory()->create()->id,
            'subtitle' => $this->faker->randomElement(self::SUBTITLES),
            'linkedin_url' => $this->faker->parse('https://linkedin.com/') . $this->faker->userName,
            'github_url' => $this->faker->parse('https://github.com/') . $this->faker->userName,
            'tags_ids' => $tagsIds ,
            'specialization' => $this->faker->randomElement(
                ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'Not Set'],
            ),
            'project_ids' => json_encode($projectIds),
            'about' => $this->faker->paragraph,
            'modality' => $this->faker->randomElements(['Presencial', 'Híbrid', 'Remot'], rand(1, 3)),
            'additional_trainings_ids' => json_encode($additionalTrainingsIds),
        ];
    }

}
