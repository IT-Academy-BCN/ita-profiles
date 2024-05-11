<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\LanguageService;
use App\Models\Resume;
use App\Models\Student;
use Tests\Fixtures\LanguagesForResume;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class LanguageServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $languageService;
    protected $studentWithoutLanguages;
    protected $studentWithLanguages;
    protected $studentWithoutResume;
    protected $languages;

    public function setUp(): void
    {
        parent::setUp();

        $this->languageService = new LanguageService();

        $this->studentWithoutLanguages = Resume::factory()->create()->student;

        $resume = Resume::factory()->create();

        $this->languages = LanguagesForResume::createLanguagesForResume($resume,2);

        $this->studentWithLanguages = $resume->student;

        $this->studentWithoutResume = Student::factory()->create();
    }

    public function testLanguageServiceReturnsValidLanguageDetailsForStudentWithLanguages(): void
    {

        $response = $this->languageService->execute($this->studentWithLanguages->id);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('languages', $response);
        $this->assertIsArray($response['languages']);
        $this->assertCount(2, $response['languages']);
        foreach ($response['languages'] as $language) {
            $this->assertIsArray($language);
        }
        $this->assertArrayHasKey('language_id', $response['languages'][0]);
        $this->assertArrayHasKey('language_name', $response['languages'][0]);
        $this->assertArrayHasKey('language_level', $response['languages'][0]);
        $this->assertArrayHasKey('language_id', $response['languages'][1]);
        $this->assertArrayHasKey('language_name', $response['languages'][1]);
        $this->assertArrayHasKey('language_level', $response['languages'][1]);
    }

    public function testLanguageServiceReturnsAnEmptyArrayInCaseOfStudentWithoutLanguages(): void
    {
        $response = $this->languageService->execute($this->studentWithoutLanguages->id);

        $this->assertIsArray($response);
        
        $this->assertCount(0, $response['languages']);
    }

    public function testLanguageServiceThrowsStudentNotFountExceptionIfRecievesNonExistentStudendId(): void
    {
        $this->expectException(StudentNotFoundException::class);

        $this->languageService->execute('nonExistentStudentId');
    }

    public function testLanguageServiceThrowsResumeNotFoundExceptionForStudentWithoutResume(): void
    {
        $this->expectException(ResumeNotFoundException::class);

        $this->languageService->execute($this->studentWithoutResume->id);
    }
}
