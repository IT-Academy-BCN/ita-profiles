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

        $response = $this->get(route('student.detail', ['id' => $student->student_id]));

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
                'project_ids',
                'created_at',
                'updated_at',
                'about'
            ]    
       
        ]);
    }

    public function test_student_details_not_found()
    {
        $response = $this->get(route('student.detail', ['id' => '12345']));

        $response->assertStatus(404);
        $response->assertJson(['error' => 'No se encontró ningún estudiante con el ID especificado']);
    }

}