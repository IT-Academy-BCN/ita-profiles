<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Models\Tag;
use Exception;

class UpdateStudentSkillsService
{
    public function updateSkillsByStudentId(string $studentId, array $skills): Exception | bool
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        $tags = Tag::whereIn('tag_name', $skills);
        $additionalTagsIds = $tags->pluck('id')->toArray();
        $student->tags()->sync($additionalTagsIds);

        return true;
    }
}
