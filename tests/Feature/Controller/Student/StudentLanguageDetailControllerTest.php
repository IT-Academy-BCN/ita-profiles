<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use Tests\Fixtures\LanguagesForResume;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Http\Controllers\api\Student\StudentLanguagesDetailController;
use App\Service\Student\StudentLanguageDetailService;

class StudentLanguageDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Students::aStudent();

        $resume = Resumes::createResumeWithModality($this->student->id, 'frontend', [1, 3], 'Presencial');

        LanguagesForResume::createLanguagesForResume($resume, 2);
    }

    public function testStudentLanguageDetailControllerReturns_200StatusForValidStudentUuidWithLanguages(): void
    {
        $response = $this->getJson(route('student.languages', ['studentId' =>  $this->student->id]));

        $response->assertStatus(200);

        $response->assertJson([]);
    }

    public function testStudentLanguageDetailControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('student.languages', ['studentId' =>  'nonExistentStudentId']));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }

    public function testStudentLanguageDetailControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume(): void
    {
        $this->student->resume->delete();

        $response = $this->getJson(route('student.languages', ['studentId' =>  $this->student->id]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $this->student->id]);
    }

    public function testStudentLanguageDetailControllerCanBeInstantiated(): void
    {
        $languageService = $this->createMock(StudentLanguageDetailService::class);

        $controller = new StudentLanguagesDetailController($languageService);

        $this->assertInstanceOf(StudentLanguagesDetailController::class, $controller);
    }

}
