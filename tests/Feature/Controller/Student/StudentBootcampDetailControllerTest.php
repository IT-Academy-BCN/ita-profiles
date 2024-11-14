<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentBootcampDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentWithoutBootcamps;
    protected $studentWithBootcamps;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentWithoutBootcamps = Student::has('resume.bootcamps', '=', 0)->first();

        $this->studentWithBootcamps = Student::has('resume.bootcamps', '>', 0)->first();
    }

    public function testStudentBootcampDetailControllerGetStudentBootcampDetails(): void
    {
        $response = $this->getJson(route('student.bootcamp', ['student' => $this->studentWithBootcamps->id]));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'bootcamps' => [
                '*' => [
                    'id',
                    'name',
                    'end_date',
                ],
            ],
        ]);
    }

    public function testStudentBootcampDetailControllerHandlesNonexistentStudent(): void
    {
        $nonexistentUuid = "00000000-0000-0000-0000-000000000000";

        $response = $this->getJson(route('student.bootcamp', ['student' => $nonexistentUuid]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No query results for model [App\\Models\\Student] ' . $nonexistentUuid]);
    }

    public function testStudentBootcampDetailControllerReturnsEmptyArrayForStudentWithoutBootcamp(): void
    {
        $response = $this->getJson(route('student.bootcamp', ['student' => $this->studentWithoutBootcamps->id]));

        $response->assertStatus(200);

        $response->assertJson(['bootcamps' => []]);
    }
}
