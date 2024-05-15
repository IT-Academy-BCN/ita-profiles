<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class ModalityService
{
    public function execute(string $studentId): array
    {
        return $this->getModalityByStudentId($studentId);
    }

    public function getModalityByStudentId(string $studentId): array
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        $resume = $student->resume()->first();

        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }

        $modality = $resume->modality;

        return (array) $modality;
    }
}
