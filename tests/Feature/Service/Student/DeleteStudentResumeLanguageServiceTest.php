<?php
declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use App\Models\{
    Language,
    Resume,
    Student,
    User
};
use Illuminate\Foundation\Testing\{
    DatabaseTransactions
};
use App\Exceptions\{
    StudentNotFoundException,
    ResumeNotFoundException,
    StudentLanguageResumeNotFoundException
};
use App\Service\Student\DeleteStudentResumeLanguageService;
use Tests\TestCase;

class DeleteStudentResumeLanguageServiceTest extends TestCase
{
    use DatabaseTransactions;

    private DeleteStudentResumeLanguageService $deleteStudentResumeLanguageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteStudentResumeLanguageService = new DeleteStudentResumeLanguageService();
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

    public function test_can_instantiate_DeleteStudentResumeLanguageService(): void
    {
        $this->assertInstanceOf(DeleteStudentResumeLanguageService::class, $this->deleteStudentResumeLanguageService);
    }

    public function test_can_delete_student_resume_language(): void
    {
        [$student, $resume, $languageId] = $this->createStudentWithResumeAndLanguage();

        $this->assertDatabaseHas('language_resume', [
            'resume_id' => $resume->id,
            'language_id' => $languageId
        ]);

        $this->deleteStudentResumeLanguageService->execute($student->id, $languageId);

        $this->assertDatabaseMissing('language_resume', [
            'resume_id' => $resume->id,
            'language_id' => $languageId
        ]);
    }

    public function test_throws_exception_if_student_not_found(): void
    {
        $this->expectException(StudentNotFoundException::class);

        $invalidStudentId = 'invalid-student-id';
        $languageId = $this->getARandomLanguageId();

        $this->deleteStudentResumeLanguageService->execute($invalidStudentId, $languageId);
    }

    public function test_throws_exception_if_resume_not_found(): void
    {
        $this->expectException(ResumeNotFoundException::class);

        $user = User::factory()->create();
        $student = Student::factory()->for($user)->create();
        $languageId = $this->getARandomLanguageId();

        $this->deleteStudentResumeLanguageService->execute($student->id, $languageId);
    }

    public function test_throws_exception_if_language_not_found_in_resume(): void
    {
        $this->expectException(StudentLanguageResumeNotFoundException::class);

        $user = User::factory()->create();
        $student = Student::factory()->for($user)->create();
        Resume::factory()->for($student)->create();
        $languageId = $this->getARandomLanguageId();

        $this->deleteStudentResumeLanguageService->execute($student->id, $languageId);
    }
}
