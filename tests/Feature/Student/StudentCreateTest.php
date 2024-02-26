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

        $this->artisan('migrate:fresh --seed');
    }

    /** @test */
    public function a_student_can_be_created(): void
    {
        $initialCount = Student::count();
        $payload = [
            'name' => 'John',
            'surname' => 'Doe',
            'status' => StudentStatus::ACTIVE,
        ];
        $this->withHeaders(['Accept' => 'application/json'])
        ->postJson(route('student.create'), $payload)
        ->assertStatus(201)
        ->assertHeader('Content-Type', 'application/json');
        $this->assertCount($initialCount + 1, Student::all());
        $this->assertDatabaseCount('students', $initialCount + 1);
        $this->assertDatabaseHas('students', $payload);
    }

}
