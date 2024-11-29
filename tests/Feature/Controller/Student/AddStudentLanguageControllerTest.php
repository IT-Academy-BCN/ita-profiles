<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Resume;
use App\Models\Language;
use App\Http\Controllers\api\Student\AddStudentLanguageController;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;

class AddStudentLanguageControllerTest extends TestCase
{
    use DatabaseTransactions;

    private const INVALID_STUDENT_ID = 'invalidStudentId';
    private const NON_EXISTENT_LANGUAGE_ID = 'ab9bb2ed-8bb5-4a3a-bdb2-09cd00000f0b';
    private const INVALID_LANGUAGE_ID = 'invalidLanguageId';
    protected User $user;
    protected Student $student;
    protected Resume $resume;
    protected Language $language;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->student = Student::factory()->for($this->user)->create();

        $this->resume = Resume::factory()->create([
            'student_id' => $this->student->id,
            'github_url' => 'https://github.com/user1',
        ]);

        //Language has no factory because it has fixed values in the seeder
        $this->language = Language::first();
        Passport::actingAs($this->user);
    }
    public function testAddStudentLanguageControllerAddsLanguageSuccessfully(): void
    {
        $response = $this->postJson(route('student.addLanguage', ['student' => $this->student]), [
            'language_id' => $this->language->id,
        ]);

        $response->assertStatus(200);
    }

    public function testAddStudentLanguageControllerReturns404ForInvalidStudentUuid(): void
    {
        $response = $this->postJson(route('student.addLanguage', ['student' => self::INVALID_STUDENT_ID]), [
            'language_id' => $this->language->id,
        ]);

        $response->assertStatus(404);
    }

    public function testAddStudentLanguageControllerReturns404ForValidStudentUuidWithoutResume(): void
    {
        $this->resume->delete();

        $response = $this->postJson(route('student.addLanguage', ['student' => $this->student]), [
            'language_id' => $this->language->id,
        ]);

        $response->assertStatus(404);
    }

    public function testAddStudentLanguageControllerReturns422ForNonExistentLanguageUuid(): void
    {
        $response = $this->postJson(route('student.addLanguage', ['student' => $this->student]), [
            'language_id' => self::NON_EXISTENT_LANGUAGE_ID,
        ]);

        $response->assertStatus(422);
    }

    public function testAddStudentLanguageControllerReturns422ForInvalidLanguageUuid(): void
    {
        $response = $this->postJson(route('student.addLanguage', ['student' => $this->student]), [
            'language_id' => self::INVALID_LANGUAGE_ID,
        ]);

        $response->assertStatus(422);
    }

    public function testAddStudentLanguageControllerCanBeInstantiated(): void
    {
        $controller = new AddStudentLanguageController();

        $this->assertInstanceOf(AddStudentLanguageController::class, $controller);
    }
}
