<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Resume;
use App\Service\StudentDetailService;
use App\Models\Student;

class StudentDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStudentDetailsAreFound()
    {
        $studentDetailService = $this->createMock(StudentDetailService::class);

        $student = Student::factory()->create();
    
        $studentId = $student->id;
        
        $studentDetail = Resume::factory()->create(['student_id' => $studentId]);
        $studentDetailService->expects($this->once())
                              ->method('execute')
                              ->with($studentId)
                              ->willReturn($studentDetail->toArray());

        $this->app->instance(StudentDetailService::class, $studentDetailService);

        $response = $this->get(route('student.detail', ['id' => $studentId]));

        $response->assertStatus(200);

        $response->assertJsonStructure();

    }

    public function testStudentDetailsIsNotFound()
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
