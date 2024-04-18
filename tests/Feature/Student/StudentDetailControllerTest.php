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
        

        $response = $this->get('/api/v1/student/detail/for-home/9bd3b026-7e95-4c35-92bb-f10452905e5a');

        $response->assertStatus(200);
        
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