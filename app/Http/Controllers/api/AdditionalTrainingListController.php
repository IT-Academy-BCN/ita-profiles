<?php

namespace App\Http\Controllers\api;
use App\Models\Student;
use App\Models\AdditionalTraining;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdditionalTrainingListController extends Controller
{
    public function __invoke($uuid){

        $student = Student::where('id', $uuid)->with('resume')->firstOrFail();

        $resume = $student->resume;

        $additionalTrainingIds = json_decode($resume->additional_trainings_ids);

        $additionalTrainings = AdditionalTraining::findMany($additionalTrainingIds);

        $additionalTrainingDetail = [
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

        return response()->json($additionalTrainingDetail);
    }

}
