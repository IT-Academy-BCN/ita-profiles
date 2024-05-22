<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use Tests\Fixtures\LanguagesForResume;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentLanguagesDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;

    public function setUp(): void
    {
        parent::setUp();

        $this->student = Students::aStudent();

        $resume = Resumes::createResumeWithModality($this->student->id, 'frontend', ['tag1', 'tag2'], 'Presencial');

        LanguagesForResume::createLanguagesForResume($resume, 2);
    }

    public function testLanguageControllerReturns_200StatusForValidStudentUuidWithLanguages(): void
    {
        $response = $this->getJson(route('student.languages', ['studentId' =>  $this->student->id]));
        $response->assertStatus(200);
        $response->assertJson([]);
    }

    public function testLanguageControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('student.languages', ['studentId' =>  'nonExistentStudentId']));
        $response->assertStatus(404);
        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }

    public function testLanguageControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume(): void
    {
        $this->student->resume->delete();
        $response = $this->getJson(route('student.languages', ['studentId' =>  $this->student->id]));
        $response->assertStatus(404);
        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $this->student->id]);
    }

}
