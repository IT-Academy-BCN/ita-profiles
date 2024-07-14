<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Language;
use App\Models\Student;
use App\Models\Resume;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\LanguageNotFoundException;
use App\Exceptions\LanguageAlreadyExistsException;
use Illuminate\Support\Facades\DB;

class AddStudentLanguageService
{
    public function execute(string $studentId, array $languageData): void
    {
        $student = $this->getStudent($studentId);
        $resume = $this->getResumeByStudent($student);
        $language = $this->getLanguageById($languageData['language_id']);

        $this->addLanguage($resume, $language);
    }

    private function getStudent(string $studentId): Student
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }
        return $student;
    }

    private function getResumeByStudent(Student $student): Resume
    {
        $resume = $student->resume()->first();

        if (!$resume) {
            throw new ResumeNotFoundException($student->id);
        }
        return $resume;
    }

    private function getLanguageById(string $languageId): Language
    {
        $language = Language::find($languageId);

        if (!$language) {
            throw new LanguageNotFoundException($languageId);
        }
        return $language;
    }

    private function addLanguage(Resume $resume, Language $language): void
    {
        DB::transaction(function () use ($resume, $language) {
            if ($resume->languages()->where('language_id', $language->id)->exists()) {
                
                $languageId = $language->id;
                $studentId = $resume->student_id;

                throw new LanguageAlreadyExistsException($languageId, $studentId);
            }
            $resume->languages()->attach($language->id);
        });
    }
}
