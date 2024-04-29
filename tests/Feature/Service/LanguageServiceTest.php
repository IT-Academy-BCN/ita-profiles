<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\LanguageService;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\LanguageNotFoundException;
use App\Exceptions\ResumeNotFoundException;

use Illuminate\Support\Str;

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
        
        $languages = [];

        for ($i = 0; $i < 2; $i++) {
            $language = $resume->languages()->create([
                'language_id' => Str::uuid(),
                'language_name' => 'Language ' . ($i + 1),
                'language_level' => 'Bàsic',
            ]);
            $languages[] = [
                'language_id' => $language->id,
                'language_name' => $language->language_name,
                'language_level' => $language->language_level,
            ];
        }

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