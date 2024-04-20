<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Resume;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\ModalityNotFoundException;
use App\Exceptions\StudentNotFoundException;


class ModalityService
{
    public function execute($studentId)
    {
        $modality = $this->getModalityByStudentId($studentId);
        return $modality;
    }

    public function getModalityByStudentId($studentId)
    {
        try {
            Student::findOrFail($studentId);
        } catch (ModelNotFoundException $e) {
            throw new StudentNotFoundException($studentId);
        }
    
        try {
            $resume = Resume::where('student_id', $studentId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModalityNotFoundException($studentId);
        }
    
        $modality = $resume->modality;
    
        if ($modality === null) {
            throw new ModalityNotFoundException($studentId);
        }

        return $resume->modality;
    }
}
