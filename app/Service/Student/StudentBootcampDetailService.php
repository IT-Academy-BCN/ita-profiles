<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentBootcampDetailService
{
    public function execute(string $studentId): array
    {
        try {
            $student = Student::findOrFail($studentId);
        } catch (ModelNotFoundException) {
            throw new StudentNotFoundException($studentId);
        }
        $resume = $student->resume;
        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }
        $bootcamps = $resume->bootcamps;

        $bootcampDetails = $bootcamps->map(function ($bootcamp) {
            return [
                'bootcamp_id' => $bootcamp->id,
                'bootcamp_name' => $bootcamp->name,
                'bootcamp_end_date' => $bootcamp->pivot->end_date,
            ];
        })->toArray();

        return [
            'bootcamps' => $bootcampDetails,
        ];
    }
}
