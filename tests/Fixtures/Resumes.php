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
}