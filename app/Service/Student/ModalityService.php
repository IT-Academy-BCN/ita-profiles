<?php

declare(strict_types=1);

namespace App\Service\Student;;

use App\Models\Resume;

class ModalityService
{
    public function execute($studentId)
    {

        $modality = $this->getModalityByStudentId($studentId);

        if (!$modality) {
            throw new \Exception('No se encontró el currículum del usuario', 404);
        }

        return $modality;
    }

    public function getModalityByStudentId($studentId)
    {
        $resume = Resume::where('student_id', $studentId)->first();
        return $resume ? $resume->modality : null;
    }
}
