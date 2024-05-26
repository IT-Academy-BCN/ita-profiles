<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Http\Controllers\api\Student\StudentDetailController;
use App\Service\Student\StudentDetailService;
use App\Models\Student;

class StudentDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;
    protected $resume;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();

        $this->resume = $this->student->resume()->create();
    }
    
    public function testStudentDetailsAreFound(): void
    {
        $studentDetailService = $this->createMock(StudentDetailService::class);

        $student = $this->student;
    
        $studentId = $student->id;
        
        $studentDetail = $this->resume;

        $studentDetailService->expects($this->once())
                              ->method('execute')
                              ->with($studentId)
                              ->willReturn($studentDetail->toArray());

        $this->app->instance(StudentDetailService::class, $studentDetailService);

        $response = $this->get(route('student.details', ['studentId' => $studentId]));

        $response->assertStatus(200);

        $response->assertJsonStructure();
    }

    public function testStudentDetailsIsNotFound(): void
    {
        $studentDetailService = $this->createMock(StudentDetailService::class);

        $studentId = 12345;

        $studentDetailService->expects($this->once())
                              ->method('execute')
                              ->with($studentId)
                              ->willThrowException(new \App\Exceptions\StudentNotFoundException((string)$studentId));

        $this->app->instance(StudentDetailService::class, $studentDetailService);

        $response = $this->get(route('student.details', ['studentId' => $studentId]));

        $response->assertStatus(404);
        
        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: 12345']);
    }

    public function testStudentDetailControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume(): void
    {
        $this->student->resume->delete();

        $response = $this->get(route('student.details', ['studentId' => $this->student]));

        $response->assertStatus(404);
        
        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $this->student->id]);
    }

    public function testStudentDetailControllerCanBeInstantiated():void
    {
        $studentDetailService = $this->createMock(StudentDetailService::class);
        
        $controller = new StudentDetailController($studentDetailService);

        $this->assertInstanceOf(StudentDetailController::class, $controller);
    }
}
