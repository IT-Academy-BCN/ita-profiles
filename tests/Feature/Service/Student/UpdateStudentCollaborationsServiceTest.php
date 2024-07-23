<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use App\Models\Resume;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Student;

class UpdateStudentCollaborationsServiceTest extends TestCase
{
    use DatabaseTransactions;

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
}
