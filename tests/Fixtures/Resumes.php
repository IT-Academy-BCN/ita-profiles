<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Models\Resume;

class Resumes
{
    public static function createResume($studentId, $specialization, $tagIds): Resume
    {
        $resume = Resume::factory()->create([
            'student_id' => $studentId,
            'specialization' => $specialization,
        ]);
        $resume->student->tags()->sync($tagIds);

        return $resume;
    }
    public static function createResumeWithModality($studentId, $specialization, $tagIds, $modality): Resume
    {
        $resume = Resume::factory()->create([
            'student_id' => $studentId,
            'specialization' => $specialization,
            'modality' => $modality,
        ]);
        $resume->student->tags()->sync($tagIds);

        return $resume;
    }
    public static function createResumeWithoutModality($studentId, $specialization, $tagIds): Resume
    {
        $resume = Resume::factory()->create([
            'student_id' => $studentId,
            'specialization' => $specialization,
            'modality' => null,
        ]);
        $resume->student->tags()->sync($tagIds);

        return $resume;
    }
    public static function createResumeWithAllFields($studentId, $subtitle, $linkedinUrl, $githubUrl, $tagsIds, $specialization, $projectIds, $modality, $additionalTrainingsIds): Resume
    {
        $specialization = substr($specialization, 0, 255);

        $resume = Resume::factory()->create([
            'student_id' => $studentId,
            'subtitle' => $subtitle,
            'linkedin_url' => $linkedinUrl,
            'github_url' => $githubUrl,
            'specialization' => $specialization,
            'modality' => $modality,
        ]);
        $resume->student->tags()->sync($tagsIds);
        $resume->projects()->sync($projectIds);

        $resume->additionalTrainings()->sync($additionalTrainingsIds);

        return $resume;
    }
    public static function createResumeWithEmptyProjects(
        $studentId,
        $subtitle = 'Subtitle',
        $linkedinUrl = 'linkedin-url',
        $githubUrl = 'github-url',
        $tagsIds = [12, 6],
        $specialization = 'Frontend',
        $modality = 'Modality',

    ): Resume {
        $specialization = substr($specialization, 0, 255);

        $resume = Resume::factory()->create([
            'student_id' => $studentId,
            'subtitle' => $subtitle,
            'linkedin_url' => $linkedinUrl,
            'github_url' => $githubUrl,
            'specialization' => $specialization,
            'modality' => $modality,
        ]);

        return $resume;
    }
}
