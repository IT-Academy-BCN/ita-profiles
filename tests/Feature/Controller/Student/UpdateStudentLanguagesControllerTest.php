<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Http\Controllers\api\Student\UpdateStudentLanguagesController;
use App\Http\Requests\UpdateStudentLanguagesRequest;
use App\Models\Student;
use App\Models\Resume;
use App\Service\Student\UpdateStudentLanguagesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Mockery;

class UpdateStudentLanguagesControllerTest extends TestCase
{
    use RefreshDatabase;

    private $updateStudentLanguagesService;
    private UpdateStudentLanguagesController $controller;
    private Student $student;
    private Resume $resume;

    protected function setUp(): void
    {
        parent::setUp();

        $this->updateStudentLanguagesService = Mockery::mock(UpdateStudentLanguagesService::class);
        $this->controller = new UpdateStudentLanguagesController($this->updateStudentLanguagesService);

        $this->student = Student::factory()->create();
        $this->resume = Resume::factory()->create(['student_id' => $this->student->id]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_invoke_updates_language_successfully(): void
    {
        $request = UpdateStudentLanguagesRequest::create('/test', 'POST', [
            'language_name' => 'Anglès',
            'language_level' => 'Natiu'
        ]);

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

        $response = $this->controller->__invoke($this->student->id, $request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'Language updated successfully'], $response->getData(true));
    }

    public function test_invoke_returns_404_when_language_not_found(): void
    {
        $request = UpdateStudentLanguagesRequest::create('/test', 'POST', [
            'language_name' => 'Francès',
            'language_level' => 'Bàsic'
        ]);

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

        $response = $this->controller->__invoke($this->student->id, $request);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['message' => 'Language not found for this student'], $response->getData(true));
    }

    public function test_invoke_returns_404_when_student_not_found(): void
    {
        $request = UpdateStudentLanguagesRequest::create('/test', 'POST', [
            'language_name' => 'Català',
            'language_level' => 'Avançat'
        ]);

        $this->updateStudentLanguagesService->shouldReceive('findStudentById')
            ->once()
            ->with('non-existent-id')
            ->andThrow(new ModelNotFoundException());

        $response = $this->controller->__invoke('non-existent-id', $request);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['message' => 'Student or Language not found'], $response->getData(true));
    }

    public function test_invoke_returns_500_on_general_exception(): void
    {
        $request = UpdateStudentLanguagesRequest::create('/test', 'POST', [
            'language_name' => 'Català',
            'language_level' => 'Intermedi'
        ]);

        $this->updateStudentLanguagesService->shouldReceive('findStudentById')
            ->once()
            ->with($this->student->id)
            ->andThrow(new \Exception('Some unexpected error'));

        $response = $this->controller->__invoke($this->student->id, $request);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals(['message' => 'An error occurred while updating the language'], $response->getData(true));
    }
}
