<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Resume;

class StudentDetailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_details_found()
    {
        $student = Resume::factory()->create();

        $response = $this->get('/api/student/' . $student->id);

        $response->assertStatus(200);
        $response->assertJson($student->toArray());
    }

    public function test_student_details_not_found()
    {
        $response = $this->get('/api/student/1');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'No se encontró ningún estudiante con el ID especificado']);
    }

    public function test_student_details_with_multiple_resumes()
    {
        $student = Resume::factory()->count(3)->create(['student_id' => 1]);

        $response = $this->get('/api/student/1');

        $response->assertStatus(200);
        $response->assertJson($student->toArray());
    }

    public function test_student_details_with_no_resumes()
    {
        $student = Resume::factory()->create(['student_id' => 1]);
        Resume::where('student_id', 1)->delete();

        $response = $this->get('/api/student/1');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'No se encontró ningún estudiante con el ID especificado']);
    }
}