<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Resume;
use App\Models\Student;
use App\Models\Language;
use Illuminate\Support\Facades\DB;
use App\Exceptions\StudentNotFoundException;

class UpdateStudentLanguagesService
{
    public function execute(string $studentId, array $languages): void
    {
        DB::transaction(function () use ($studentId, $languages) {
            $this->updateStudentLanguagesLevel($studentId, $languages);
        });
    }

    private function updateStudentLanguagesLevel(string $studentId, array $languages): void
    {
        $student = $this->getStudentById($studentId);
        $resume = $student->resume;

        foreach ($languages as $languageData) {
            $language = $this->getLanguageByName($resume, $languageData['language_name']);
            if ($language) {
                $this->updateLanguage($language, $languageData['language_level']);
            }
        }
    }

    private function getStudentById(string $studentId): Student
    {
        $student = Student::find($studentId);
        if (!$student) throw new StudentNotFoundException("Student with ID $studentId not found");

        return $student;
    }

    private function getLanguageByName(Resume $resume, string $languageName): ?Language
    {
        return $resume->languages()->where('language_name', $languageName)->first();
    }

    private function updateLanguage(Language $language, string $level): void
    {
        $language->update([
            'language_level' => $level
        ]);
    }
}
