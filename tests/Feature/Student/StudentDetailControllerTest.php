<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Resume;
use App\Service\StudentDetailService;
use App\Models\Student;

class StudentDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_student_details_found()
    {
        $studentDetailService = $this->createMock(StudentDetailService::class);

        $student = Student::factory()->create();
    
        $studentId = $student->id;
        
        $studentDetails = Resume::factory()->create();
        $studentDetailService->expects($this->once())
                              ->method('execute')
                              ->with($studentId)
                              ->willReturn($studentDetails);

        $this->app->instance(StudentDetailService::class, $studentDetailService);

        $response = $this->get(route('student.detail', ['id' => $studentId]));

        $response->assertStatus(200);

        $response->assertJsonStructure();

    }

    public function test_student_details_not_found()
    {
        $studentDetailService = $this->createMock(StudentDetailService::class);

        $studentId = 12345;
        $studentDetailService->expects($this->once())
                              ->method('execute')
                              ->with($studentId)
                              ->willThrowException(new \App\Exceptions\StudentNotFoundException($studentId));

        $this->app->instance(StudentDetailService::class, $studentDetailService);

        $response = $this->get(route('student.detail', ['id' => $studentId]));

        $response->assertStatus(404);
        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: 12345']);
    }
}
