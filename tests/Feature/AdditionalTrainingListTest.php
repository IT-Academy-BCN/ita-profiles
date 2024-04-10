<?php 

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\AdditionalTraining;

class AdditionalTrainingListTest extends TestCase
{
    protected $student;
    protected $additionalTrainings;

    public function setUp(): void
    {
        parent::setUp();

        
        $this->student = Student::factory()->create();

        
        $this->additionalTrainings = AdditionalTraining::factory()->count(3)->create();
        $this->student->resume()->create([
            'additional_trainings_ids' => json_encode($this->additionalTrainings->pluck('id')->toArray())
        ]);
    }

    public function test_controller_returns_correct_response_with_valid_uuid()
    {
        $response = $this->get(route('additionaltraining.list', ['student' => $this->student->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'additional_trainings' => [
                    '*' => [
                        'uuid',
                        'course_name',
                        'study_center',
                        'course_beggining_year',
                        'course_ending_year',
                        'duration_hrs',
                    ]
                ]
            ]);
    }

    public function test_controller_returns_empty_array_with_no_additional_trainings_listed()
    {
        
        $this->student->resume()->update(['additional_trainings_ids' => '[]']);

        $response = $this->get(route('additionaltraining.list', ['student' => $this->student->id]));

        $response->assertStatus(200)
            ->assertExactJson(['additional_trainings' => []]);
    }

    public function test_controller_returns_404_with_invalid_uuid()
    {
        $invalidUuid = 'invalid_uuid';

        $response = $this->get(route('additionaltraining.list', ['student' => $invalidUuid]));

        $response->assertStatus(404);
    }
}