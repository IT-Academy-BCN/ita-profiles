<?php
declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\{
    StudentNotFoundException,
    ResumeNotFoundException
};

class UpdateStudentProfileService
{
    public function execute(Student $student, array $data): void
    {
        $this->updateStudentProfile($student, $data);
    }

    public function updateStudentProfile(Student $student, array $data): void
    {
        $this->updateStudent($student, $data);
        $this->updateResume($student, $data);
        $this->updateStudentTags($student, $data);
    }

    public function updateStudent(Student $student, array $data): void
    {
        $student->name = $data['name'] ?? $student->name;
        $student->surname = $data['surname'] ?? $student->surname;
        $student->update($data);
    }

    private function updateResume(Student $student, array $data): void
    {
        $resume = $student->resume;
        if (!$resume) {
            throw new ResumeNotFoundException($student->id);
        }

        $resume->subtitle = $data['subtitle'] ?? $resume->subtitle;
        $resume->github_url = $data['github_url'] ?? $resume->github_url;
        $resume->linkedin_url = $data['linkedin_url'] ?? $resume->linkedin_url;
        $resume->about = $data['about'] ?? $resume->about;
        $resume->update($data);
    }

    private function updateStudentTags(Student $student, array $data): void
    {
        if (isset($data['tags_ids'])) {
        $student->tags()->sync($data['tags_ids']);
        }
    }
}
