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
    public function execute(string $studentId, array $data): bool
    {
        return $this->updateStudentProfile($data, $studentId);
    }

    public function updateStudentProfile(array $data, string $studentId):bool
    {
        $student = $this->getStudentById($studentId);
        $wasStudentUPdated = $this->updateStudent($data, $student);
        $wasResumeUpdated = $this->updateResume($data, $student);

        return $wasStudentUPdated && $wasResumeUpdated;
    }

    private function getStudentById(string $studentId): Student
    {
        $student = Student::find($studentId);
        if (!$student) throw new StudentNotFoundException($studentId);

        return $student;
    }

    private function updateStudent(array $data, Student $student):bool
    {
        return $student->update([
            'name' => $data['name'],
            'surname' => $data['surname'],
        ]);
    }

    private function updateResume(array $data, Student $student):bool
    {
        $resume =  $student->resume;
        if (!$resume) throw new ResumeNotFoundException($student->id);

        return $resume->update([
            'subtitle' => $data['subtitle'],
            'github_url' => $data['github_url'],
            'linkedin_url' => $data['linkedin_url'],
            'about' => $data['about'],
        ]);
    }

}

