<?php

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Student;

class StudentIndexTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
    }
    public function tearDown(): void
    {
        $this->artisan('migrate:fresh --seed');
    }
    /** @test */
    public function a_list_of_students_can_be_getted(): void
    {
        $students = Student::factory()->count(2)->create();
        $student1 = $students->first();
        $student2 = $students->last();

        $response = $this->getJson(route('students.list'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonFragment([
            'data' => [
                [
                'name' => $student1->name,
                'surname' => $student1->surname,
                'photo' => $student1->photo,
                'status' => $student1->status,
                'id' => $student1->id
                ],
                [
                'name' => $student2->name,
                'surname' => $student2->surname,
                'photo' => $student2->photo,
                'status' => $student2->status,
                'id' => $student2->id
                ],
            ],
        ]);
    }
}
