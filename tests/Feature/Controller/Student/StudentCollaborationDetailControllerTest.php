<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Collaboration;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\api\Student\StudentCollaborationDetailController;
use App\Service\Student\StudentCollaborationDetailService;

use Illuminate\Support\Facades\DB;

class StudentCollaborationDetailControllerTest extends TestCase
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

    
    public function testStudentCollaborationDetailControllerReturns_200StatusForValidStudentUuidWithCollaborations(): void
    {
        $collaboration1 = Collaboration::factory()->create();

        $collaboration2 = Collaboration::factory()->create();
		
		DB::table('resume_collaboration')->insert(
			[
				'resume_id' => $this->resume->id,
				'collaboration_id' => $collaboration1->id,
			]
		);
		DB::table('resume_collaboration')->insert(
			[
				'resume_id' => $this->resume->id,
				'collaboration_id' => $collaboration2->id,
			]
		);
		
        $response = $this->getJson(route('student.collaborations', ['studentId' => $this->student->id]));

        $response->assertStatus(200);

        $response->assertJsonStructure(['collaborations']);
        
        
    }

    public function testStudentCollaborationDetailControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('student.collaborations', ['studentId' =>  'nonExistentStudentId']));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }

    public function testStudentCollaborationDetailControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume(): void
    {
        $this->student->resume->delete();

        $response = $this->getJson(route('student.collaborations', ['studentId' =>  $this->student->id]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $this->student->id]);
    }

    public function testStudentCollaborationDetailControllerCanBeInstantiated(): void
    {
        $studentCollaborationService = $this->createMock(StudentCollaborationDetailService::class);
    
        $controller = new StudentCollaborationDetailController($studentCollaborationService);

        $this->assertInstanceOf(StudentCollaborationDetailController::class, $controller);
    }
}
