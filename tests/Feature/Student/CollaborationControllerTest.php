<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Collaboration;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CollaborationControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;
    protected $resume;

    public function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();

        $this->resume = $this->student->resume()->create();
    }

    public function testCollaborationControllerReturns_200StatusForValidStudentUuidWithCollaborations(): void
    {

        $collaboration1 = Collaboration::factory()->create();

        $collaboration2 = Collaboration::factory()->create();

        $this->resume->collaborations_ids = json_encode([$collaboration1->id, $collaboration2->id]);

        $this->resume->save();

        $response = $this->getJson(route('collaborations.list', ['student' => $this->student->id]));

        $response->assertStatus(200);

        $response->assertJsonStructure(['collaborations']);
    }

    public function testCollaborationControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('collaborations.list', ['student' =>  'nonExistentStudentId']));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }

    public function testCollaborationControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume(): void
    {
        $this->student->resume->delete();

        $response = $this->getJson(route('collaborations.list', ['student' =>  $this->student->id]));

        $response->assertStatus(404);
        
        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $this->student->id]);
    }

}
