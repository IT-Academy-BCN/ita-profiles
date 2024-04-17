<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Bootcamp;
use App\Models\Student;

class StudentBootcampDetailService
/**
 * Fetches bootcamp details associated with a specific student by UUID.
 *
 * @param string $uuid The UUID of the student.
 * @return array An array of bootcamp details associated with the student.
 *
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
