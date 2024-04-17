<?php

declare(strict_types=1);

namespace App\Service\Student;;

use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\ModalityNotFoundException;


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
            $resume = Resume::where('student_id', $studentId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModalityNotFoundException($studentId);
        }
    
        return $resume->modality;
    }
}
