<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Exceptions\StudentNotFoundException;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentBootcampDetailService
{
    public function execute(string $uuid): array
{
    try {
        $student = Student::findOrFail($uuid);
        $resume = $student->resume;
        $bootcamps = $resume->bootcamps;
    } catch (ModelNotFoundException $e) {
        throw new StudentNotFoundException($uuid);
    }

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
