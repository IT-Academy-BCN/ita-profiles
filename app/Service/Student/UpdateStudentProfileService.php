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
    public function execute(string $studentId, array $data): void
    {
        $this->updateStudentProfile($studentId, $data);
    }

    public function updateStudentProfile(string $studentId, array $data): void
    {
        $student = $this->getStudentById($studentId);
        $this->updateFields($student, $data, ['name', 'surname']);
        $this->updateResume($student, $data);
    }

    private function getStudentById(string $studentId): Student
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        return $student;
    }

    private function updateFields($model, array $data, array $fields): void
    {
        $updateData = [];
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $updateData[$field] = $data[$field];
            }
        }

        if (!empty($updateData)) {
            $model->update($updateData);
        }
    }

    private function updateResume(Student $student, array $data): void
    {
        $resume = $student->resume;
        if (!$resume) {
            throw new ResumeNotFoundException($student->id);
        }

        $this->updateFields($resume, $data, ['subtitle', 'github_url', 'linkedin_url', 'about', 'tags_ids']);
    }
}
