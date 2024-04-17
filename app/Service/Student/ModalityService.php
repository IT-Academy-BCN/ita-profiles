<?php

declare(strict_types=1);

namespace App\Service\Student;;

use App\Models\Resume;

class ModalityService
{
    public function execute($studentId)
    {
        $modality = $this->getModalityByStudentId($studentId);
        return $modality;
    }

    public function getModalityByStudentId($studentId)
    {
        $resume = Resume::where('student_id', $studentId)->firstOrFail();
        return $resume ? $resume->modality : null;
    }
}
