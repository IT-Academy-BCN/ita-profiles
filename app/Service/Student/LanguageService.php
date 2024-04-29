<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\LanguageNotFoundException;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class LanguageService
{
    public function execute($studentId)
    {
        return $this->getLanguageByStudentId($studentId);
    }

    public function getLanguageByStudentId($studentId)
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        $resume = $student->resume()->first();

        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }

        $languages = $resume->languages;

        if (count($languages) < 1) {
            throw new LanguageNotFoundException($studentId);
        }

        return $languages->map(function ($language) {
    return [
        'language_id' => $language->id,
        'language_name' => $language->language_name,
        'language_level' => $language->language_level,
    ];
    })->toArray();
    }
}
