<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\Fixtures\{
    Students,
    Resumes,
    LanguagesForResume,
};
use App\Models\{
    Resume,
    Student,
};
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Http\Controllers\api\Student\StudentLanguagesDetailController;
use Illuminate\Support\Collection;

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

    public function testCanInstantiateAStudent(): void
    {
        $this->assertInstanceOf(Student::class, $this->student);
    }

    public function testCanGetAResumeOfAStudent(): void
    {
        $this->assertInstanceOf(Resume::class, $this->student->resume);
    }

    public function testCanGetLanguagesOfAStudent(): void
    {
        $languages = $this->student->resume?->languages ?? collect();

        $this->assertInstanceOf(Collection::class, $languages);
    }

    public function testStudentLanguageDetailControllerCanBeInstantiated()
    {
        $this->assertInstanceOf(StudentLanguagesDetailController::class, new StudentLanguagesDetailController());
    }

    public function testReturns200WithLanguagesUuid(): void
    {
        $response = $this->get( uri: route(name: 'student.languages', parameters: $this->student));

        $response->assertStatus(200);
        $response->assertJsonStructure(structure: [
            'data' => [
                '*' =>[
                        'id',
                        'name',
                        'level'
                    ]
            ]
        ]);
    }

    public function testReturns404WithInvalidStudentUuid(): void
    {
        $invalidUuid = 'invalidUuid';

        $response = $this->get(uri: route(name: 'student.languages', parameters: $invalidUuid));

        $response->assertJson(['message' => 'No query results for model [App\\Models\\Student] ' . $invalidUuid]);
        $response->assertStatus(404);
    }

    public function testReturnsAnEmptyArrayWhenThereIsNotResume(): void
    {
        $resume = $this->student->resume;
        $resume->delete();

        $response = $this->get(uri: route(name: 'student.languages', parameters: $this->student));

        $response->assertStatus(200);
        $response->assertJson(['data' => []]);
    }
    public function testReturnsAnEmptyArrayWhenThereAreNotLanguagesForStudent(): void
    {
        $resume = $this->student->resume;
        $resume->languages()->detach();

        $response = $this->get(uri: route(name: 'student.languages', parameters: $this->student));

        $response->assertStatus(200);
        $response->assertJson(['data' => []]);
    }
}
