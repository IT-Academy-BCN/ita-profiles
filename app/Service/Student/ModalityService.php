<?php

declare(strict_types=1);

namespace App\Service\Student;;

use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModalityService
{
    public function execute($studentId)
    {

        $modality = $this->getModalityByStudentId($studentId);

        if (!$modality) {
            throw new ModelNotFoundException('No se encontró el currículum del usuario', 404);
            //throw new \Exception('No se encontró el currículum del usuario', 404);
        }

        return $modality;
    }

    public function getModalityByStudentId($studentId)
    {
        $resume = Resume::where('student_id', $studentId)->first();
        return $resume ? $resume->modality : null;
    }
}
