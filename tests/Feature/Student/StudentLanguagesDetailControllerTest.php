<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Str;

class StudentLanguagesDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;

    public function setUp(): void
    {
        parent::setUp();

        $this->student = Students::aStudent();

        $resume = Resumes::createResumeWithModality($this->student->id, 'frontend', ['tag1', 'tag2'], 'Presencial');
        
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
    }

    public function testLanguageControllerReturns_200StatusForValidStudentUuidWithLanguages(): void
    {
        $response = $this->getJson(route('languages.list', ['id' =>  $this->student->id]));
        $response->assertStatus(200);
    }

    public function testLanguageControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('languages.list', ['id' =>  'nonExistentStudentId']));
        $response->assertStatus(404);
        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }

    public function testLanguageControllerReturns_404StatusAndLanguageNotFoundExceptionMessageForValidStudentUuidWithoutLanguages(): void
    {
        $this->student->resume->languages()->delete();
        $response = $this->getJson(route('languages.list', ['id' =>  $this->student->id]));
        $response->assertStatus(404);
        $response->assertJson(['message' => 'L\'estudiant amb ID: ' . $this->student->id . ' no té informat cap idioma al seu currículum']);
    }

    public function testLanguageControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume(): void
    {
        $this->student->resume->delete();
        $response = $this->getJson(route('languages.list', ['id' =>  $this->student->id]));
        $response->assertStatus(404);
        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $this->student->id]);
    }

}