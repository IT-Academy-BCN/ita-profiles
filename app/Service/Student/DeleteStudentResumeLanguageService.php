<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Exceptions\{
    ResumeNotFoundException,
    StudentLanguageResumeNotFoundException,
    StudentNotFoundException
};
use App\Models\{
    Student,
    Resume
};

class DeleteStudentResumeLanguageService
{
    public function execute(string $studentId, string $languageId): void
    {
        $this->deleteResumeLanguage($studentId, $languageId);
    }

    private function deleteResumeLanguage(string $studentId, string $languageId): void
    {
        $student = $this->getStudentByIdOrThrowException($studentId);
        $resume = $this->getResumeOrThrowException($student);

        if (!$resume->languages()->find($languageId)) {
            throw new StudentLanguageResumeNotFoundException($studentId, $languageId);
        }
        $resume->languages()->detach($languageId);
    }

    private function getStudentByIdOrThrowException(string $studentId): Student
    {
        $student = Student::find($studentId);
        if (!$student){
            throw new StudentNotFoundException($studentId);
        }
        return $student;
    }

    private function getResumeOrThrowException(Student $student): Resume
    {
        $resume = $student->resume;
        if (!$resume){
            throw new ResumeNotFoundException($student->id);
        }
        return $resume;
    }

}
