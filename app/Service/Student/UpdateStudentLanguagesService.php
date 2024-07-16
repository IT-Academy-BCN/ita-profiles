<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Language;
use App\Models\Student;
use App\Models\Resume;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\LanguageNotFoundException;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateStudentLanguageService
{
    public function execute(string $studentId, array $languageData): void
    {
        DB::transaction(function () use ($studentId, $languageData) {
            $this->updateLanguageLevel($studentId, $languageData);
        });
    }

    private function updateLanguageLevel(string $studentId, array $languageData): void
    {
        $student = $this->getStudent($studentId);
        $resume = $this->getResumeByStudent($student);
        $languageId = $languageData['language_id'];
        $newLevel = $languageData['language_level'];

        $this->validateLanguageExists($languageId);

        if (!$resume->languages()->where('languages.id', $languageId)->exists()) {
            throw new LanguageNotFoundException("Language with ID $languageId is not associated with student");
        }

        $resume->languages()->updateExistingPivot($languageId, ['language_level' => $newLevel]);
    }

    private function getStudent(string $studentId): Student
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new StudentNotFoundException("Student with ID $studentId not found");
        }
        return $student;
    }

    private function getResumeByStudent(Student $student): Resume
    {
        $resume = $student->resume()->first();
        if (!$resume) {
            throw new ResumeNotFoundException("Resume not found for student with ID {$student->id}");
        }
        return $resume;
    }

    private function validateLanguageExists(string $languageId): void
    {
        $language = Language::find($languageId);
        if (!$language) {
            throw new LanguageNotFoundException("Language with ID $languageId not found");
        }
    }
}
