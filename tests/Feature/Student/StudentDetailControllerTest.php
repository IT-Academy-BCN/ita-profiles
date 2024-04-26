<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Resume;
use App\Service\StudentDetailsService;
use App\Models\Student;

class StudentDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_student_details_found()
    {
        $studentDetailsService = $this->createMock(StudentDetailsService::class);

        $student = Student::factory()->create();
    
        $studentId = $student->id;
        
        $studentDetails = Resume::factory()->create(['student_id' => $studentId]);
        $studentDetailsService->expects($this->once())
                              ->method('execute')
                              ->with($studentId)
                              ->willReturn($studentDetails);

        $this->app->instance(StudentDetailsService::class, $studentDetailsService);

        $response = $this->get(route('student.detail', ['student' => $studentId]));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [ 
                'id',
                'student_id',
                'subtitle',
                'linkedin_url',
                'github_url',
                'tags_ids',
                'specialization',
                'modality',
                'project_ids',
                'created_at',
                'updated_at',
                'additional_trainings_ids',
                'about'
            ]    
        ]);
    }

    public function test_student_details_not_found()
    {
        $studentDetailsService = $this->createMock(StudentDetailsService::class);

        $studentId = 12345;
        $studentDetailsService->expects($this->once())
                              ->method('execute')
                              ->with($studentId)
                              ->willThrowException(new \App\Exceptions\StudentDetailsNotFoundException($studentId));

        $this->app->instance(StudentDetailsService::class, $studentDetailsService);

        $response = $this->get(route('student.detail', ['student' => $studentId]));

        $response->assertStatus(404);
        $response->assertJson(['message' => 'No se encontró ningún estudiante con el ID especificado']);
    }
}
