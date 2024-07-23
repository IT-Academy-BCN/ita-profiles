<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Resume;
use App\Models\Language;
use App\Http\Controllers\api\Student\AddStudentLanguageController;
use App\Service\Student\AddStudentLanguageService;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class AddStudentLanguageControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;    
    protected $resume;
    protected $language;

    protected function setUp(): void
    {
        parent::setUp();       

        $this->student = Student::factory()->create();
        
        $this->resume = Resume::factory()->create(['student_id' => $this->student->id]);

        //Language has no factory because it has fixed values in the seeder      
        $this->language = Language::first();    
    }
    public function testAddStudentLanguageControllerAddsLanguageSuccessfully(): void
    {
        $response = $this->postJson(route('student.addLanguage', ['studentId' => $this->student->id]), [
            'language_id' => $this->language->id,
        ]);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'L\'idioma s\'ha afegit']);
    }

    public function testAddStudentLanguageControllerReturns404ForInvalidStudentUuid(): void
    {
        $invalidStudentId = 'invalidStudentId';

        $response = $this->postJson(route('student.addLanguage', ['studentId' => $invalidStudentId]), [
            'language_id' => $this->language->id,
        ]);

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: ' . $invalidStudentId]);
    }

    public function testAddStudentLanguageControllerReturns404ForValidStudentUuidWithoutResume(): void
    {
        $this->resume->delete();

        $response = $this->postJson(route('student.addLanguage', ['studentId' => $this->student->id]), [
            'language_id' => $this->language->id,
        ]);

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $this->student->id]);
    }

    public function testAddStudentLanguageControllerReturns422ForNonExistentLanguageUuid(): void
    {
        $noExistentLanguageId = 'ab9bb2ed-8bb5-4a3a-bdb2-09cd00000f0b';
        
        $response = $this->postJson(route('student.addLanguage', ['studentId' => $this->student->id]), [
            'language_id' => $noExistentLanguageId,
        ]);

        $response->assertStatus(422);
        
        $response->assertJson([
            'errors' => [
                'language_id' => [
                    'Language id és invàlid.'
                ]
            ]
        ]);
    }

    public function testAddStudentLanguageControllerReturns422ForInvalidLanguageUuid(): void
    {
        $invalidLanguageId = 'invalidLanguageId';
        
        $response = $this->postJson(route('student.addLanguage', ['studentId' => $this->student->id]), [
            'language_id' => $invalidLanguageId,
        ]);

        $response->assertStatus(422);
        
        $response->assertJson([
            'errors' => [
                'language_id' => [
                    'El language id ha de ser un indentificador únic universal (UUID) vàlid.'
                ]
            ]
        ]);
    }

    public function testAddStudentLanguageControllerReturns409ForDuplicateLanguage(): void
    {
        $languageToAdd = $this->language->id;
        $studentId = $this->student->id;

        // add language
        $this->postJson(route('student.addLanguage', ['studentId' => $studentId]), [
            'language_id' =>  $languageToAdd,
        ]);

        // add same language again
        $response = $this->postJson(route('student.addLanguage', ['studentId' => $studentId]), [
            'language_id' =>  $languageToAdd,
        ]);

        $response->assertStatus(409);

        $response->assertJson(['message' => sprintf('L\'idioma %s ja existeix al perfil de l\'estudiant %s', $languageToAdd, $studentId)]);
    }

    public function testAddStudentLanguageControllerCanBeInstantiated(): void
    {
        $languageService = $this->createMock(AddStudentLanguageService::class);
        
        $controller = new AddStudentLanguageController($languageService);

        $this->assertInstanceOf(AddStudentLanguageController::class, $controller);
    }
}