<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\ValueObjects\StudentStatus;
use App\Models\Student;

class StudentCreateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function a_student_can_be_created(): void
    {
        $payload = [
            'name' => 'John',
            'surname' => 'Doe',
            'status' => StudentStatus::ACTIVE,
        ];
        $this->withHeaders(['Accept' => 'application/json'])
        ->postJson(route('student.create'), $payload)
        ->assertStatus(201)
        ->assertHeader('Content-Type', 'application/json');
        $this->assertCount(1, Student::all());
        $this->assertDatabaseCount('students', 1);
        $this->assertDatabaseHas('students', $payload);
    }

}
