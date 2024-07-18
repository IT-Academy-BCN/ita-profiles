<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Language;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateStudentLanguagesService
{
    public function findStudentById(string $studentId): Student
    {
        try {
            $student = Student::findOrFail($studentId);
            return $student;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Student not found');
        }
    }

    public function findStudentResume(Student $student)
    {
        try {
            $resume = $student->resume()->firstOrFail();
            return $resume;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Resume not found for the student');
        }
    }

    public function getResumeLanguages($resume)
    {
        try {
            // Return a collection of Language models directly without converting to an array
            $languages = $resume->languages()->get();
            return $languages;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Languages not found for the resume');
        }
    }

    public function findLanguageByNameAndLevel(string $languageName, string $languageLevel): Language
    {
        try {
            $language = Language::where('language_name', $languageName)
                ->where('language_level', $languageLevel)
                ->firstOrFail();
            return $language;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Language not found');
        }
    }

    public function updateStudentLanguage($resume, $languageName, $languageLevel): bool
    {
        $newLanguage = $this->findLanguageByNameAndLevel($languageName, $languageLevel);
        $languagesToUpdate = $this->getResumeLanguages($resume);

        foreach ($languagesToUpdate as $languageToUpdate) {
            if ($languageToUpdate->language_name === $languageName) {
                $resume->languages()->updateExistingPivot($languageToUpdate->id, ['language_id' => $newLanguage->id]);
                return true; // Language updated successfully
            }
        }

        return false; // Language not found
    }
}
