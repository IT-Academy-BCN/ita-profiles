<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use App\Models\{
    Language,
    Resume,
    Student
};
use App\Service\Student\UpdateStudentLanguagesService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateStudentLanguagesServiceTest extends TestCase
{
    use DatabaseTransactions;

    private UpdateStudentLanguagesService $updateStudentLanguagesService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->updateStudentLanguagesService = new UpdateStudentLanguagesService();
    }

    private function createFakeDataForStudentWithLanguages(): array
    {
        $student = Student::factory()->has(Resume::factory())->create();
        $resume = $student->resume()->first();
        $language = Language::factory()->create(['language_name' => 'Anglès', 'language_level' => 'Bàsic']);
        $resume->languages()->attach($language->id);

        return [$student, $resume, $language];
    }

    public function test_find_student_by_id()
    {
        $student = Student::factory()->create();
        $foundStudent = $this->updateStudentLanguagesService->findStudentById($student->id);
        $this->assertEquals($student->id, $foundStudent->id);
    }

    public function test_find_student_by_id_throws_model_not_found_exception()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->updateStudentLanguagesService->findStudentById('non-existent-id');
    }

    public function test_find_student_resume()
    {
        [$student, $resume] = $this->createFakeDataForStudentWithLanguages();
        $foundResume = $this->updateStudentLanguagesService->findStudentResume($student);
        $this->assertEquals($resume->id, $foundResume->id);
    }

    public function test_find_student_resume_throws_model_not_found_exception()
    {
        $student = Student::factory()->create();
        $this->expectException(ModelNotFoundException::class);
        $this->updateStudentLanguagesService->findStudentResume($student);
    }

    public function test_get_resume_languages()
    {
        [$student, $resume, $language] = $this->createFakeDataForStudentWithLanguages();
        $languages = $this->updateStudentLanguagesService->getResumeLanguages($resume);
        $this->assertCount(1, $languages);
        $this->assertEquals($language->id, $languages->first()->id);
    }

    public function test_find_language_by_name_and_level()
    {
        $language = Language::factory()->create(['language_name' => 'Anglès', 'language_level' => 'Intermedi']);
        $foundLanguage = $this->updateStudentLanguagesService->findLanguageByNameAndLevel('Anglès', 'Intermedi');
        $this->assertEquals($language->id, $foundLanguage->id);
    }

    public function test_find_language_by_name_and_level_throws_model_not_found_exception()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->updateStudentLanguagesService->findLanguageByNameAndLevel('Nonexistent Language', 'Nonexistent Level');
    }

    public function test_update_student_language()
    {
        [$student, $resume, $oldLanguage] = $this->createFakeDataForStudentWithLanguages();
        $newLanguage = Language::factory()->create(['language_name' => 'Anglès', 'language_level' => 'Intermedi']);

        $result = $this->updateStudentLanguagesService->updateStudentLanguage($resume, 'Anglès', 'Intermedi');
        $this->assertTrue($result);

        $updatedLanguage = $resume->languages()->first();
        $this->assertEquals($newLanguage->id, $updatedLanguage->id);
        $this->assertEquals('Intermedi', $updatedLanguage->language_level);
    }

    public function test_update_student_language_returns_false_if_language_not_found()
    {
        [$student, $resume] = $this->createFakeDataForStudentWithLanguages();

        $result = $this->updateStudentLanguagesService->updateStudentLanguage($resume, 'Nonexistent Language', 'Intermedi');
        $this->assertFalse($result);
    }
}
