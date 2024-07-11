<?php
declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use Illuminate\Support\Facades\Storage;

class UpdateStudentImageService
{
    public function execute(string $studentId, string $filename): void
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException("Student not found with ID {$studentId}");
        }

        if ($student->photo) {
            Storage::delete('public/photos/' . $student->photo);
        }

        $student->photo = $filename;
        $student->save();
    }
}
