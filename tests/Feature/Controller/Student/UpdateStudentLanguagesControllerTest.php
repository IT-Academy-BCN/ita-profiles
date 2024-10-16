<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\Student;
use App\Models\Resume;
use App\Service\Student\UpdateStudentLanguagesService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;

class UpdateStudentLanguagesControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $updateStudentLanguagesService;
    private $student;
    private $resume;

    protected function setUp(): void
    {
        parent::setUp();

        $this->updateStudentLanguagesService = Mockery::mock(UpdateStudentLanguagesService::class);
        $this->app->instance(UpdateStudentLanguagesService::class, $this->updateStudentLanguagesService);

        $this->student = Student::factory()->create();
        $this->resume = Resume::factory()->create(['student_id' => $this->student->id]);
    }

    public function test_invoke_updates_language_successfully(): void
    {
        $this->updateStudentLanguagesService->shouldReceive('findStudentById')
            ->once()
            ->with($this->student->id)
            ->andReturn($this->student);

        $this->updateStudentLanguagesService->shouldReceive('findStudentResume')
            ->once()
            ->with($this->student)
            ->andReturn($this->resume);

        $this->updateStudentLanguagesService->shouldReceive('updateStudentLanguage')
            ->once()
            ->with($this->resume, 'Anglès', 'Natiu')
            ->andReturn(true);

        $response = $this->putJson(route('student.languages.update', ['studentId' => $this->student->id]), [
            'name' => 'Anglès',
            'level' => 'Natiu'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Language updated successfully']);
    }

    public function test_invoke_returns_404_when_language_not_found(): void
    {
        $this->updateStudentLanguagesService->shouldReceive('findStudentById')
            ->once()
            ->with($this->student->id)
            ->andReturn($this->student);

        $this->updateStudentLanguagesService->shouldReceive('findStudentResume')
            ->once()
            ->with($this->student)
            ->andReturn($this->resume);

        $this->updateStudentLanguagesService->shouldReceive('updateStudentLanguage')
            ->once()
            ->with($this->resume, 'Francès', 'Bàsic')
            ->andReturn(false);

        $response = $this->putJson(route('student.languages.update', ['studentId' => $this->student->id]), [
            'name' => 'Francès',
            'level' => 'Bàsic'
        ]);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Language not found for this student']);
    }

    public function test_invoke_returns_404_when_student_not_found(): void
    {
        $this->updateStudentLanguagesService->shouldReceive('findStudentById')
            ->once()
            ->with('non-existent-id')
            ->andThrow(new ModelNotFoundException());

        $response = $this->putJson(route('student.languages.update', ['studentId' => 'non-existent-id']), [
            'name' => 'Català',
            'level' => 'Avançat'
        ]);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Student or Language not found']);
    }

    public function test_invoke_returns_500_on_general_exception(): void
    {
        $this->updateStudentLanguagesService->shouldReceive('findStudentById')
            ->once()
            ->with($this->student->id)
            ->andThrow(new \Exception('Some unexpected error'));

        $response = $this->putJson(route('student.languages.update', ['studentId' => $this->student->id]), [
            'name' => 'Català',
            'level' => 'Intermedi'
        ]);

        $response->assertStatus(500);
        $response->assertJson(['message' => 'An error occurred while updating the language']);
    }
}
