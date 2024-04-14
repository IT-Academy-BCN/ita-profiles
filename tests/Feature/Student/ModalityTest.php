<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Resume;
use App\Models\Student;
use Tests\Fixtures\Students;

class ModalityTest extends TestCase
{
    use DatabaseTransactions;

    public function test_modality_controller_returns_200_status_if_a_student_has_resume()
    {
        $student = Student::first();

        if (!$student) {
            $student = Students::aStudent();
        }
    
        $studentId = $student->id;

        $resume = Resume::where('student_id', $studentId)->first();

        $this->assertNotNull($resume);

        $response = $this->getJson(route('modality', ['studentId' => $studentId]));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'modality' => []
        ]);
    }

    public function test_modality_controller_returns_404_status_if_a_student_has_no_resume()
    {
        $student = Student::first();

        if (!$student) {
            $student = Student::factory()->create();
        }

        $studentId = $student->id;

        Resume::where('student_id', $studentId)->delete();

        $response = $this->getJson(route('modality', ['studentId' => $studentId]));

        $response->assertStatus(404);
    }
}

