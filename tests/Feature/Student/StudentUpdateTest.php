<?php

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Student;
use App\ValueObjects\StudentStatus;

class StudentUpdateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
    }
    /** @test */

    public function student_data_can_be_updated(): void
    {
        $students = Student::factory()->create();
        $student = $students->first();

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->putJson(
                route('student.update', $student),
                [
                'name' => 'Johnny',
                'surname' => 'Doe',
                'photo' => 'http://www.photo.com/johnnydoe',
                'status' => 'Inactive',
                ],
            );

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');

        $updatedStudent = $student->fresh();

        $this->assertEquals('Johnny', $updatedStudent->name);
        $response->assertExactJson([
            'data' => [
                'name' => 'Johnny',
                'surname' => 'Doe',
                'photo' => 'http://www.photo.com/johnnydoe',
                'status' => StudentStatus::INACTIVE,
            ],
        ]);
    }
}
