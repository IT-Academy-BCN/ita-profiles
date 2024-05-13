<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class LanguageService
{
    public function execute(string $studentId): array
    {
        return $this->getLanguageByStudentId($studentId);
    }

    public function getLanguageByStudentId(string $studentId): array
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        $resume = $student->resume()->first();

        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }

        return $this->mapLanguageDetails($resume->languages);
    }

    private function mapLanguageDetails(object $languages): array
    {
        return $languages->map(function ($language) {
            return [
                'language_id' => $language->id,
                'language_name' => $language->language_name,
                'language_level' => $language->language_level,
            ];
        })->toArray();
    }
}
