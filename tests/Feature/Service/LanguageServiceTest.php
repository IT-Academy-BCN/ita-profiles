<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\LanguageService;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use Tests\Fixtures\LanguagesForResume;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\LanguageNotFoundException;
use App\Exceptions\ResumeNotFoundException;


class LanguageServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $languageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->languageService = new languageService();
    }

    public function testLanguageServiceReturnsValidLanguageDetailsForStudentWithLanguages()
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        $resume = Resumes::createResumeWithModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');

        $languages = LanguagesForResume::createLanguagesForResume($resume,2);

        $response = $this->languageService->execute($student->id);

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertEquals($languages[0], $response[0]);
        $this->assertEquals($languages[1], $response[1]);
        $this->assertIsArray($response[0]);
        $this->assertIsArray($response[1]);
        $this->assertArrayHasKey('language_id', $response[0]);
        $this->assertArrayHasKey('language_name', $response[0]);
        $this->assertArrayHasKey('language_level', $response[0]);
        
    }

    public function testLanguageServiceThrowsStudentNotFountExceptionIfRecievesNonExistentStudendId()
    {
        $this->expectException(StudentNotFoundException::class);
        $this->languageService->execute('nonExistentStudentId');
    }

    public function testLanguageServiceThrowsLanguageNotFoundExceptionForstudentWithoutLanguages()
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        Resumes::createResumeWithModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');
        
        $this->expectException(LanguageNotFoundException::class);

        $this->languageService->execute($studentId);

    }

    public function testLanguageServiceThrowsResumeNotFoundExceptionForstudentWithoutResume()
    {
        $student = Students::aStudent();

        $studentId = $student->id;
        
        $this->expectException(ResumeNotFoundException::class);

        $this->languageService->execute($studentId);

    }
}