<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Models\Student;

class StudentBootcampDetailService
{
    public function execute(string $studentId): array
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }
        $resume = $student->resume;
        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }
        $bootcampDetails = $this->mapBootcampDetails($resume->bootcamps);
        return [
            'bootcamps' => $bootcampDetails,
        ];
    }
    private function mapBootcampDetails(object $bootcamps): array
    {
        return $bootcamps->map(function ($bootcamp) {
            return [
                'bootcamp_id' => $bootcamp->id,
                'bootcamp_name' => $bootcamp->name,
                'bootcamp_end_date' => $bootcamp->pivot->end_date,
            ];
        })->toArray();
    }
}
