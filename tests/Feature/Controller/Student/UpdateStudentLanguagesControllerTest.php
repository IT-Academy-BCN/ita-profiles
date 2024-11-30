<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Resume;
use App\Models\Language;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateStudentLanguagesControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $student;
    private $resume;
    private $language;

    protected function setUp(): void
    {
        parent::setUp();
        Language::query()->delete();

        $this->user = User::factory()->create();
        $this->student = Student::factory()->has(Resume::factory())->create(['user_id' => $this->user->id]);
        $this->resume = $this->student->resume()->first();

        $this->language = Language::firstOrCreate(
            ['name' => 'Anglès', 'level' => 'Natiu'],
            ['id' => (string) Str::uuid()]
        );
        $this->resume->languages()->syncWithoutDetaching($this->language->id);

        Passport::actingAs($this->user);
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
