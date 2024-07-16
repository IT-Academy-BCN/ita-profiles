<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\Resume;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Student;

class UpdateStudentCollaborationsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testUpdateCollaborationsForValidStudent(): void
    {
        $studentId = Resume::first()->student_id;
        $payload = [
            'collaborations' => [10, 20],
        ];

        $response = $this->json('PUT', route('student.updateCollaborations', ['studentId' => $studentId]), $payload);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Collaborations updated successfully']);
    }

    public function testStudentNotFound(): void
    {
        $studentId = 'nonExistentStudentId';
        $payload = [
            'collaborations' => [10, 20],
        ];

        $response = $this->json('PUT', route('student.updateCollaborations', ['studentId' => $studentId]), $payload);

        $response->assertStatus(404)
            ->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }

    public function testResumeNotFound(): void
    {
        $student = Student::factory()->create();
        $payload = [
            'collaborations' => [10, 20],
        ];

        $response = $this->json('PUT', route('student.updateCollaborations', ['studentId' => $student->id]), $payload);

        $response->assertStatus(404)
            ->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: '.$student->id]);
    }

    public function testValidationFailsForInvalidDataItem1(): void
    {
        $studentId = Resume::first()->student_id;
        $payload = [
            'collaborations' => ['invalid', 20],
        ];

        $response = $this->json('PUT', route('student.updateCollaborations', ['studentId' => $studentId]), $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['collaborations.0'])
            ->assertJsonFragment([
                'collaborations.0' => ['Collaborations.0 ha de ser un nombre enter.']
            ]);
    }

    public function testValidationFailsForInvalidDataItem2(): void
    {
        $studentId = Resume::first()->student_id;
        $payload = [
            'collaborations' => [10, 'invalid'],
        ];

        $response = $this->json('PUT', route('student.updateCollaborations', ['studentId' => $studentId]), $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['collaborations.1'])
            ->assertJsonFragment([
                'collaborations.1' => ['Collaborations.1 ha de ser un nombre enter.']
            ]);
    }

    public function testPartialDataHandlingItem1(): void
    {
        $studentId = Resume::first()->student_id;
        $payload = [
            'collaborations' => [null, 20],
        ];

        $response = $this->json('PUT', route('student.updateCollaborations', ['studentId' => $studentId]), $payload);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Collaborations updated successfully']);
    }

    public function testPartialDataHandlingItem2(): void
    {
        $studentId = Resume::first()->student_id;
        $payload = [
            'collaborations' => [10, null], // Un valor nulo
        ];

        $response = $this->json('PUT', route('student.updateCollaborations', ['studentId' => $studentId]), $payload);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Collaborations updated successfully']);
    }

    public function testInvalidNumberOfCollaborations(): void
    {
        $studentId = Resume::first()->student_id;
        $payload = [
            'collaborations' => [10],
        ];

        $response = $this->json('PUT', route('student.updateCollaborations', ['studentId' => $studentId]), $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['collaborations']);
    }
}
