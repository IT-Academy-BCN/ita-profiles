<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\StudentLanguageDetailService;
use App\Models\Resume;
use App\Models\Student;
use Tests\Fixtures\LanguagesForResume;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class StudentLanguageDetailServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentLanguageDetailService;
    protected $studentWithoutLanguages;
    protected $studentWithLanguages;
    protected $studentWithoutResume;
    protected $languages;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentLanguageDetailService = new StudentLanguageDetailService();

        $this->studentWithoutLanguages = Resume::factory()->create()->student;

        $resume = Resume::factory()->create();

        $this->languages = LanguagesForResume::createLanguagesForResume($resume,2);

        $this->studentWithLanguages = $resume->student;

        $this->studentWithoutResume = Student::factory()->create();
    }

    public function testLanguageServiceReturnsValidLanguageDetailsForStudentWithLanguages(): void
    {

        $response = $this->studentLanguageDetailService->execute($this->studentWithLanguages->id);

        $this->assertIsArray($response);

        $this->assertCount(2, $response);

        $expectedKeys = ['language_id', 'language_name', 'language_level'];
        
        foreach ($response as $languageDetails) {
            foreach ($expectedKeys as $key) {
                $this->assertArrayHasKey($key, $languageDetails);
            }
        }
    }

    public function testLanguageServiceReturnsAnEmptyArrayInCaseOfStudentWithoutLanguages(): void
    {
        $response = $this->studentLanguageDetailService->execute($this->studentWithoutLanguages->id);

        $this->assertIsArray($response);
        
        $this->assertEmpty($response);
    }

    public function testLanguageServiceThrowsStudentNotFountExceptionIfRecievesNonExistentStudendId(): void
    {
        $this->expectException(StudentNotFoundException::class);

        $this->studentLanguageDetailService->execute('nonExistentStudentId');
    }

    public function testLanguageServiceThrowsResumeNotFoundExceptionForStudentWithoutResume(): void
    {
        $this->expectException(ResumeNotFoundException::class);

        $this->studentLanguageDetailService->execute($this->studentWithoutResume->id);
    }

    public function testLanguageServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(StudentLanguageDetailService::class, $this->studentLanguageDetailService);
    }
}
