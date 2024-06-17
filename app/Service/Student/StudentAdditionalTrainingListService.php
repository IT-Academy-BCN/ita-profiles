<?php 

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Models\AdditionalTraining;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;


class StudentAdditionalTrainingListService
{

    public function execute(string $studentId)
    {
        return $this->getStundentAdditionalTrainingById($studentId);
    }
    
    public function getStundentAdditionalTrainingById (string  $studentId): array {

        $student = Student::where('id', $studentId)->with('resume')->first();

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        $resume = $student->resume;

        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }
        
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
        })->toArray();





    }
}