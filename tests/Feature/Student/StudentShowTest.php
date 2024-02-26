<?php

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Student;

class StudentShowTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
    }
    /** @test */
    public function a_student_info_can_be_retrieved(): void
    {
        $students = Student::factory()->count(2)->create();
        $student2 = $students->last();

        $response = $this->getJson(route('student.show', $student2));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertExactJson([
            'data' => [
                'name' => $student2->name,
                'surname' => $student2->surname,
                'photo' => $student2->photo,
                'status' => $student2->status,
                'id' => $student2->id
            ],
        ]);
    }
}
