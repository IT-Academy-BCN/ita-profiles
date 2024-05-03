<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Models\Resume;

class Resumes
{
    public static function createResume($studentId, $specialization, $tagIds): Resume
    {
        return Resume::factory()->create([
            'student_id' => $studentId,
            'specialization' => $specialization,
            'tags_ids' => json_encode($tagIds),
        ]);
    }
    public static function createResumeWithModality($studentId, $specialization, $tagIds, $modality): Resume
    {
        return Resume::factory()->create([
            'student_id' => $studentId,
            'specialization' => $specialization,
            'tags_ids' => json_encode($tagIds),
            'modality' => $modality,
        ]);
    }
    public static function createResumeWithAllFields($studentId, $subtitle, $linkedinUrl, $githubUrl, $tagsIds, $specialization, $projectIds, $modality, $additionalTrainingsIds): Resume
    {
        $specialization = substr($specialization, 0, 255);

        return Resume::factory()->create([
            'student_id' => $studentId,
            'subtitle' => $subtitle,
            'linkedin_url' => $linkedinUrl,
            'github_url' => $githubUrl,
            'tags_ids' => json_encode($tagsIds),
            'specialization' => $specialization,
            'project_ids' => json_encode($projectIds),
            'modality' => $modality,
            'additional_trainings_ids' => json_encode($additionalTrainingsIds),
        ]);
    }
    public static function createResumeWithEmptyProjects(
        $studentId,
        $subtitle = 'Subtitle',
        $linkedinUrl = 'linkedin-url',
        $githubUrl = 'github-url',
        $tagsIds = ['tag1', 'tag2'],
        $specialization = 'Frontend',
        $modality = 'Modality',
        $additionalTrainingsIds = ['additional_training1', 'additional_training2']
    ): Resume {
        $specialization = substr($specialization, 0, 255);

        $attributes = [
            'student_id' => $studentId,
            'subtitle' => $subtitle,
            'linkedin_url' => $linkedinUrl,
            'github_url' => $githubUrl,
            'tags_ids' => json_encode($tagsIds),
            'specialization' => $specialization,
            'project_ids' => '[]',
            'modality' => $modality,
            'additional_trainings_ids' => json_encode($additionalTrainingsIds),
        ];

        return Resume::factory()->create($attributes);
    }
}
