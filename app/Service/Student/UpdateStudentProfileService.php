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

    public function updateStudentProfile(string $studentId, array $data):void
    {
        $student = $this->getStudentById($studentId);
        $this->updateStudent($student, $data);
        $this->updateResume($student, $data);
    }

    private function getStudentById(string $studentId): Student
    {
        $student = Student::find($studentId);
        if (!$student) throw new StudentNotFoundException($studentId);

        return $student;
    }

    private function updateStudent(Student $student, array $data):void
    {
        $student->update([
            'name' => $data['name'],
            'surname' => $data['surname'],
        ]);
    }

    private function updateResume(Student $student, array $data):void
    {
        $resume =  $student->resume;
        if (!$resume){
            throw new ResumeNotFoundException($student->id);
        }

        $resume->update([
            'subtitle' => $data['subtitle'],
            'github_url' => $data['github_url'],
            'linkedin_url' => $data['linkedin_url'],
            'about' => $data['about'],
            'tags_ids' => $data['tags_ids']
        ]);
    }

}

