<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Resume;
use App\Models\AdditionalTraining;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\api\Student\StudentAdditionalTrainingListController;

class StudentAdditionalTrainingListControllerTest extends TestCase
{
    
    use DatabaseTransactions;
    protected $student;
    protected $additionalTrainings;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();

        $this->additionalTrainings = AdditionalTraining::factory()->count(2)->create();

        $this->student->resume()->create([
            'additional_training_ids' => json_encode($this->additionalTrainings->pluck('id')->toArray())
        ]);
    }
    
    public function testCanFindAdditionalTrainingDetails()
    {        
        $response = $this->get(route('student.additionaltraining', ['student' => $this->student]));      

        $response->assertStatus(200);

        $response->assertJsonStructure([            
                'additionalTrainings' => [
                   '*' => [               
                    'id',
                    'course_name',
                    'study_center',
                    'course_beginning_year',
                    'course_ending_year',
                    'duration_hrs'
                   ]
                ]
            ]
        );
    }

    public function testCanReturn_404WhenStudentIsNotFound()
    {
        $invalidUuid = 'invalid_uuid';

        $response = $this->get(route('student.additionaltraining', ['student' => $invalidUuid]));       

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No query results for model [App\\Models\\Student] ' . $invalidUuid]);
    }

    public function testCanReturnEmptyAdditionalTrainingsWhenNoResume()
    {
        Resume::where('student_id', $this->student->id)->delete();
                
        $response = $this->getJson(route('student.additionaltraining', ['student' => $this->student]));

        $response->assertStatus(200);
       
        $response->assertJson([]);
    }

    public function testCanReturnEmptyAdditionalTrainingsWhenNoAdditionalTrainings()
    {
       $resume = $this->student->resume;

       $resume->additionalTrainings()->detach();
                
        $response = $this->getJson(route('student.additionaltraining', ['student' => $this->student]));

        $response->assertStatus(200);
      
        $response->assertJson([]);
    }

    public function testCanBeInstantiated(): void
    {
        $studentAdditionalTrainingListController = new StudentAdditionalTrainingListController();
        $this->assertInstanceOf(StudentAdditionalTrainingListController::class, $studentAdditionalTrainingListController);
    }

}