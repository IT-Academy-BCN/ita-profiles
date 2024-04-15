<?php 

declare(strict_types=1);

namespace App\Service;

use App\Models\Student;
use App\Models\AdditionalTraining;

class AdditionalTrainingService
{
    public function getAdditionalTrainingDetails($uuid)
    {
        $student = Student::where('id', $uuid)->with('resume')->firstOrFail();
        $resume = $student->resume;
        $additionalTrainingIds = json_decode($resume->additional_trainings_ids);
        $additionalTrainings = AdditionalTraining::findMany($additionalTrainingIds);

        return $additionalTrainings->map(function ($additionalTraining) {
            return [
                'uuid' => $additionalTraining->id,
                'course_name' => $additionalTraining->course_name,
                'study_center' => $additionalTraining->study_center,
                'course_beginning_year' => $additionalTraining->course_beginning_year,
                'course_ending_year' => $additionalTraining->course_ending_year,
                'duration_hrs' => $additionalTraining->duration_hrs,
            ];
        });
    }
}
