<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\AdditionalTraining;
use App\Models\Student;

class AdditionalTrainingListService
{
    public function execute(string $uuid): array
    {
        $student = Student::where('id', $uuid)->with('resume')->firstOrFail();
        $resume = $student->resume;
        $additionalTrainingIds = json_decode($resume->additional_trainings_ids);
        $additionalTrainings = AdditionalTraining::findMany($additionalTrainingIds);
        return [
            'additional_trainings' => $additionalTrainings->map(function ($additionalTraining) {
                return [
                    'uuid' => $additionalTraining->id,
                    'course_name' => $additionalTraining->course_name,
                    'study_center' => $additionalTraining->study_center,
                    'course_beggining_year' => $additionalTraining->course_beggining_year,
                    'course_ending_year' => $additionalTraining->course_ending_year,
                    'duration_hrs' => $additionalTraining->duration_hrs,
                ];
            })
        ];
    }
}
