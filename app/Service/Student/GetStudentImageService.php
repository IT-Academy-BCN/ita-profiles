<?php
declare(strict_types=1);

namespace App\Service\Student;

use App\Exceptions\StudentNotFoundException;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class GetStudentImageService
{
    private const PHOTOS_PATH = 'public/photos/';

    public function execute(string $studentId)
    {
        $student = $this->getStudent($studentId);
        if ($student->photo != null && $student->photo != "") {
            return Storage::url(self::PHOTOS_PATH . $student->photo);
        }
        return null;
    }

    public function getStudent(string $studentId): Student
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }
        return $student;
    }
}
