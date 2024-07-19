<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use App\Models\{Language, Resume, Student};
use App\Service\Student\UpdateStudentLanguagesService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class UpdateStudentLanguagesServiceTest extends TestCase
{
    use DatabaseTransactions;

    private UpdateStudentLanguagesService $service;
    private Student $student;
    private Resume $resume;
    private Language $language;

    protected function setUp(): void
    {
        parent::setUp();
        Language::query()->delete();
        $this->service = new UpdateStudentLanguagesService();
        [$this->student, $this->resume, $this->language] = $this->createFakeDataForStudentWithLanguages();
    }

    private function createFakeDataForStudentWithLanguages(): array
    {
        $student = Student::factory()->has(Resume::factory())->create();
        $resume = $student->resume()->first();
        $language = Language::firstOrCreate(
            ['language_name' => 'Anglès', 'language_level' => 'Bàsic'],
            ['id' => (string) Str::uuid()]
        );
        $resume->languages()->syncWithoutDetaching($language->id);
        return [$student, $resume, $language];
    }

    public function test_find_student_by_id(): void
    {
        $foundStudent = $this->service->findStudentById($this->student->id);
        $this->assertInstanceOf(Student::class, $foundStudent);
        $this->assertEquals($this->student->id, $foundStudent->id);
    }

    public function test_find_student_by_id_throws_model_not_found_exception(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->findStudentById('non-existent-id');
    }

    public function test_find_student_resume(): void
    {
        $foundResume = $this->service->findStudentResume($this->student);
        $this->assertInstanceOf(Resume::class, $foundResume);
        $this->assertEquals($this->resume->id, $foundResume->id);
    }

    public function test_find_student_resume_throws_model_not_found_exception(): void
    {
        $studentWithoutResume = Student::factory()->create();
        $this->expectException(ModelNotFoundException::class);
        $this->service->findStudentResume($studentWithoutResume);
    }

    public function test_get_resume_languages(): void
    {
        $languages = $this->service->getResumeLanguages($this->resume);
        $this->assertCount(1, $languages);
        $this->assertEquals($this->language->id, $languages->first()->id);
    }

    public function test_find_language_by_name_and_level(): void
    {
        $newLanguage = Language::firstOrCreate(
            ['language_name' => 'Anglès', 'language_level' => 'Intermedi'],
            ['id' => (string) Str::uuid()]
        );
        $foundLanguage = $this->service->findLanguageByNameAndLevel('Anglès', 'Intermedi');
        $this->assertInstanceOf(Language::class, $foundLanguage);
        $this->assertEquals($newLanguage->id, $foundLanguage->id);
    }

    public function test_find_language_by_name_and_level_throws_model_not_found_exception(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->findLanguageByNameAndLevel('Nonexistent Language', 'Nonexistent Level');
    }

    public function test_update_student_language(): void
    {
        $newLanguage = Language::firstOrCreate(
            ['language_name' => 'Anglès', 'language_level' => 'Intermedi'],
            ['id' => (string) Str::uuid()]
        );

        $result = $this->service->updateStudentLanguage($this->resume, 'Anglès', 'Intermedi');
        $this->assertTrue($result);

        $updatedLanguage = $this->resume->languages()->where('language_name', 'Anglès')->first();
        $this->assertNotNull($updatedLanguage);
        $this->assertEquals($newLanguage->id, $updatedLanguage->id);
        $this->assertEquals('Intermedi', $updatedLanguage->language_level);
    }

    public function test_update_student_language_throws_exception_if_language_not_found(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error updating student language');
        $this->service->updateStudentLanguage($this->resume, 'Nonexistent Language', 'Intermedi');
    }
}
