<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Http\Controllers\api\Student\DeleteStudentResumeLanguageController;
use App\Models\{
    Language,
    Resume,
    Student,
    User
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteStudentResumeLanguageControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected string $languageId;
    protected User $user;
    protected Student $student;
    protected Resume $resume;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->student = Student::factory()->for($this->user)->create();
        $this->resume = Resume::factory()->for($this->student)->create();
        $languageIds = Language::pluck('id')->toArray();
        $this->languageId = $languageIds[array_rand($languageIds)];
        $this->resume->languages()->attach($this->languageId);
    }

    public function testCanInstantiateDeleteStudentResumeLanguageController(): void
    {
        $this->assertInstanceOf(expected: DeleteStudentResumeLanguageController::class, actual: new DeleteStudentResumeLanguageController());
    }

    public function testCanDeleteAStudentResumeLanguage(): void
    {
        $this->assertDatabaseHas('language_resume', [
            'resume_id' => $this->resume->id,
            'language_id' => $this->languageId
        ]);

        $url = route('student.language.delete', ['student' => $this->student->id, 'language' => $this->languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('language_resume', [
            'resume_id' => $this->resume->id,
            'language_id' => $this->languageId
        ]);
    }

    public function testCanReturnA404WhenAStudentIsNotFound(): void
    {
        $invalidStudentId = 'invalid-student-id';

        $url = route('student.language.delete', ['student' => $invalidStudentId, 'language' => $this->languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(404);
    }

    public function testCanReturnA404WhenAResumeIsNotFound(): void
    {
        $this->student->resume()->delete();

        $url = route('student.language.delete', ['student' => $this->student->id, 'language' => $this->languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(404);
    }

    public function testCanReturnA404WhenALanguageIsNotFoundInResume(): void
    {
        $this->resume->languages()->detach($this->languageId);

        $url = route('student.language.delete', ['student' => $this->student->id, 'language' => $this->languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(404);
    }

}
