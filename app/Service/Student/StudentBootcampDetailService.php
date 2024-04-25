<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;

class StudentBootcampDetailService
/**
 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the student is not found.
 */
{
    public function execute(string $uuid): array
    {
        $student = Student::findOrFail($uuid);
        $resume = $student->resume;
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
