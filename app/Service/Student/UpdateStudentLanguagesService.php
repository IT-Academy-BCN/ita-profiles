<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\{
    StudentNotFoundException,
};
use App\Models\Language;

class UpdateStudentProfileService
{
    public function execute(string $studentId, array $data): void
    {
        $this->updateStudentLanguagesLevel($studentId, $data);
    }

    public function updateStudentLanguagesLevel(string $studentId, array $data): void
    {
        $languages = $this->getLanguageByStudentId($studentId);
        $this->updateLangues($languages, $data);
    }

    private function getLanguageByStudentId(string $studentId): Language
    {
        $student = Student::find($studentId);
        if (!$student) throw new StudentNotFoundException($studentId);
        $languages = $student->resume->languages;

        return $languages;
    }

    private function updateLangues(Language $languages, array $data): void
    {
        $languages->update([
            'language_level' => $data['language_level']
        ]);
    }
}
