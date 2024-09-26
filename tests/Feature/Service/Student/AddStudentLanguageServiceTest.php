<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Resume;
use App\Models\Language;
use App\Service\Student\AddStudentLanguageService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\LanguageAlreadyExistsException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddStudentLanguageServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;
    protected $resume;
    protected $language;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new AddStudentLanguageService();

        $this->student = Student::factory()->create();
        $this->resume = Resume::factory()->create(['student_id' => $this->student->id]);

        // Language has no factory because it has fixed values in the seeder
        $this->language = Language::first();
    }

    public function testExecuteAddsLanguageSuccessfully(): void
    {
        $languageData = ['language_id' => $this->language->id];

        $this->service->execute($this->student->id, $languageData);

        $this->assertDatabaseHas('language_resume', [
            'resume_id' => $this->resume->id,
            'language_id' => $this->language->id,
        ]);
    }

    public function testExecuteThrowsStudentNotFoundException(): void
    {
        $this->expectException(StudentNotFoundException::class);

        $invalidStudentId = 'invalidStudentId';
        $languageData = ['language_id' => $this->language->id];

        $service = new AddStudentLanguageService();
        $service->execute($invalidStudentId, $languageData);
    }

    public function testExecuteThrowsResumeNotFoundException(): void
    {
        $this->expectException(ResumeNotFoundException::class);

        $this->resume->delete();
        $languageData = ['language_id' => $this->language->id];

        $service = new AddStudentLanguageService();
        $service->execute($this->student->id, $languageData);
    }

    public function testExecuteThrowsExceptionForNonExistentLanguageUuid(): void
    {
        $this->expectException(\Exception::class);

        $nonExistentLanguageId = 'ab9bb2ed-8bb5-4a3a-bdb2-09cd00000f0b';
        $languageData = ['language_id' => $nonExistentLanguageId];

        $service = new AddStudentLanguageService();
        $service->execute($this->student->id, $languageData);
    }

    public function testExecuteThrowsExceptionForInvalidLanguageUuid(): void
{
    $this->expectException(\Exception::class);

    $invalidLanguageId = 'invalidLanguageId';
    $languageData = ['language_id' => $invalidLanguageId];

    $service = new AddStudentLanguageService();
    $service->execute($this->student->id, $languageData);
}

    public function testExecuteThrowsLanguageAlreadyExistsException(): void
    {
        $this->expectException(LanguageAlreadyExistsException::class);

        $languageData = ['language_id' => $this->language->id];

        // Adds language first time
        $this->service->execute($this->student->id, $languageData);

        // Adds same language again
        $this->service->execute($this->student->id, $languageData);
    }
}
