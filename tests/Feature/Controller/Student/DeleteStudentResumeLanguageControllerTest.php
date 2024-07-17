<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\{
    Language,
    Resume,
    Student,
    User
};
use App\Service\Student\DeleteStudentResumeLanguageService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;

class DeleteStudentResumeLanguageControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function getARandomLanguageId(): string
    {
        $languageIds = Language::pluck('id')->toArray();
        return $languageIds[array_rand($languageIds)];
    }

    private function createStudentWithResumeAndLanguage(): array
    {
        $user = User::factory()->create();
        $student = Student::factory()->for($user)->create();
        $resume = Resume::factory()->for($student)->create();
        $languageId = $this->getARandomLanguageId();
        $resume->languages()->attach($languageId);

        return [$student, $resume, $languageId];
    }

    public function test_can_delete_a_student_resume_language(): void
    {
        [$student, $resume, $languageId] = $this->createStudentWithResumeAndLanguage();

        $this->assertDatabaseHas('language_resume', [
            'resume_id' => $resume->id,
            'language_id' => $languageId
        ]);

        $url = route('student.language.delete', ['studentId' => $student->id, 'languageId' => $languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('language_resume', [
            'resume_id' => $resume->id,
            'language_id' => $languageId
        ]);
    }

    public function test_can_return_a_404_when_a_student_is_not_found(): void
    {
        $invalidStudentId = 'invalid-student-id';
        $languageId = $this->getARandomLanguageId();

        $url = route('student.language.delete', ['studentId' => $invalidStudentId, 'languageId' => $languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(404);
    }

    public function test_can_return_a_404_when_a_resume_is_not_found(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->for($user)->create();
        $languageId = $this->getARandomLanguageId();

        $url = route('student.language.delete', ['studentId' => $student->id, 'languageId' => $languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(404);
    }

    public function test_can_return_a_404_when_a_language_is_not_found_in_resume(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->for($user)->create();
        Resume::factory()->for($student)->create();
        $languageId = $this->getARandomLanguageId();

        $url = route('student.language.delete', ['studentId' => $student->id, 'languageId' => $languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(404);
    }

    public function test_can_return_a_500_on_internal_server_error(): void
    {
        $this->mock(DeleteStudentResumeLanguageService::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')
                ->andThrow(new \Exception('Internal Server Error'));
        });

        [$student, $languageId] = $this->createStudentWithResumeAndLanguage();

        $url = route('student.language.delete', ['studentId' => $student->id, 'languageId' => $languageId]);
        $response = $this->json('DELETE', $url);

        $response->assertStatus(500);
    }
}
