<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Student;
use App\Models\Project;

class StudentProjectsDetailControllerTest extends TestCase
{
    public function test_controller_returns_correct_response_with_valid_uuid()
    {
        $student = Student::factory()->create();
        $projects = Project::factory()->count(3)->create();

        $student->resume()->create([
            'project_ids' => json_encode($projects->pluck('id')->toArray())
        ]);

        $response = $this->get(route('projects.list', ['student' => $student->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'projects' => [
                    '*' => [
                        'uuid',
                        'project_name',
                        'company_name',
                        'project_url',
                        'tags',
                        'github_url'
                    ]
                ]
            ]);
    }
}
