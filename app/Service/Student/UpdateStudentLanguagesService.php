<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Language;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateStudentLanguagesService
{
    public function findStudentById(string $studentId): Student
    {
        try {
            $student = Student::findOrFail($studentId);
            return $student;
        } catch (ModelNotFoundException $e) {
            Log::error('Student not found', ['studentId' => $studentId, 'error' => $e->getMessage()]);
            throw new ModelNotFoundException('Student not found');
        }
    }

    public function findStudentResume(Student $student)
    {
        try {
            $resume = $student->resume()->firstOrFail();
            return $resume;
        } catch (ModelNotFoundException $e) {
            Log::error('Resume not found for the student', ['studentId' => $student->id, 'error' => $e->getMessage()]);
            throw new ModelNotFoundException('Resume not found for the student');
        }
    }

    public function getResumeLanguages($resume)
    {
        try {
            $languages = $resume->languages()->get();
            return $languages;
        } catch (ModelNotFoundException $e) {
            Log::error('Languages not found for the resume', ['resumeId' => $resume->id, 'error' => $e->getMessage()]);
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
            Log::error('Language not found', ['language_name' => $languageName, 'language_level' => $languageLevel, 'error' => $e->getMessage()]);
            throw new ModelNotFoundException('Language not found');
        }
    }

    public function updateStudentLanguage($resume, $languageName, $languageLevel): bool
    {
        try {
            $newLanguage = $this->findLanguageByNameAndLevel($languageName, $languageLevel);
            $languagesToUpdate = $this->getResumeLanguages($resume);

            foreach ($languagesToUpdate as $languageToUpdate) {
                if ($languageToUpdate->language_name === $languageName) {
                    $resume->languages()->updateExistingPivot($languageToUpdate->id, ['language_id' => $newLanguage->id]);
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Error updating student language', ['resumeId' => $resume->id, 'languageName' => $languageName, 'languageLevel' => $languageLevel, 'error' => $e->getMessage()]);
            throw new \Exception('Error updating student language');
        }
    }
}
