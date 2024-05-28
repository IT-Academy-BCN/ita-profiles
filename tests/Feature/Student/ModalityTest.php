<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Resume;
use App\Models\Student;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use App\Service\Student\ModalityService;

class ModalityTest extends TestCase
{
    use DatabaseTransactions;

    public function testExecuteWithValidStudentId()
{
    $student = Students::aStudent();
    
    $studentId = $student->id;

    $resume = Resumes::createResumeWithModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');

    $modalityService = new ModalityService();

    $result = $modalityService->execute($student->id);

    $this->assertEquals($resume->modality, $result);
}

    public function test_modality_controller_returns_404_status_if_a_student_has_no_resume()
    {
        $student = Student::first();

        if (!$student) {
            $student = Student::factory()->create();
        }

        $studentId = $student->id;

        Resume::where('student_id', $studentId)->delete();

        $response = $this->getJson(route('student.modality', ['studentId' => $studentId]));

        $response->assertStatus(404);
    }
}


