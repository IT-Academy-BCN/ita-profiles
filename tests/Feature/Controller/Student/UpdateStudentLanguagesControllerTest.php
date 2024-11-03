<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\Language;
use App\Models\Student;
use App\Models\Resume;
use App\Service\Student\UpdateStudentLanguagesService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class UpdateStudentLanguagesControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $updateStudentLanguagesService;
    private $student;
    private $resume;

    protected function setUp(): void
    {
        parent::setUp();

        Language::query()->delete();
        [$this->student, $this->resume, $this->language] = $this->createFakeDataForStudentWithLanguages();
    }

    private function createFakeDataForStudentWithLanguages(): array
    {
        $student = Student::factory()->has(Resume::factory())->create();
        $resume = $student->resume()->first();
        $language = Language::firstOrCreate(
            ['name' => 'Anglès', 'level' => 'Natiu'],
            ['id' => (string) Str::uuid()]
        );
        $resume->languages()->syncWithoutDetaching($language->id);
        return [$student, $resume, $language];
    }

    public function testCanUpdateStudentLanguage(): void
    {
        $response = $this->putJson(route('student.languages.update', ['student' => $this->student]), [
            'name' => 'Anglès',
            'level' => 'Natiu'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Language updated successfully']);
    }

    public function testCanReturn404WhenLanguageNotFound(): void
    {
        $response = $this->putJson(route('student.languages.update', ['student' => $this->student]), [
            'name' => 'Anglès',
            'level' => 'Bàsic'
        ]);

        $response->assertStatus(404);
    }

    public function testCanReturn404WhenStudentNotFound(): void
    {
        $response = $this->putJson(route('student.languages.update', ['student' => 'non-existent-id']), [
            'name' => 'Català',
            'level' => 'Avançat'
        ]);

        $response->assertStatus(404);
    }
}
