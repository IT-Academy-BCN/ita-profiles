<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use App\Models\Bootcamp;
use App\Models\Resume;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\api\Student\StudentBootcampDetailController;
use App\Service\Student\StudentBootcampDetailService;
use Tests\TestCase;

class StudentBootcampDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentWithoutBootcamps;

    protected $studentWithBootcamps;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentWithoutBootcamps = Resume::factory()->create()->student;

        $resume = Resume::factory()->create();

        $bootcamp = Bootcamp::factory()->create();

        $resume->bootcamps()->attach($bootcamp->id, ['end_date' => now()->subYear()->addDays(rand(1, 365))]);

        $this->studentWithBootcamps = $resume->student;
    }

    public function testStudentBootcampDetailControllerGetStudentBootcampDetails(): void
    {
        $response = $this->getJson(route('student.bootcamp', ['studentId' =>  $this->studentWithBootcamps->id]));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'bootcamps' => [
                '*' => [
                    'bootcamp_id',
                    'bootcamp_name',
                    'bootcamp_end_date',
                ],
            ],
        ]);
    }

    public function testStudentBootcampDetailControllerHandlesNonexistentStudent(): void
    {
        $nonexistentUuid = "00000000-0000-0000-0000-000000000000";

        $response = $this->getJson(route('student.bootcamp', ['studentId' => $nonexistentUuid]));

        $response->assertStatus(404);

        $response->assertJson(['message' => "No s'ha trobat cap estudiant amb aquest ID: $nonexistentUuid"]);
    }

    public function testStudentBootcampDetailControllerReturnsEmptyArrayForStudentWithoutBootcamp(): void
    {
        $response = $this->getJson(route('student.bootcamp', ['studentId' => $this->studentWithoutBootcamps->id]));

        $response->assertStatus(200);

        $response->assertJson(['bootcamps' => []]);
    }

    public function testStudentBootcampDetailControllerCanBeInstantiated(): void
    {
        $studentBootcampDetailService = $this->createMock(StudentBootcampDetailService::class);

        $controller = new StudentBootcampDetailController($studentBootcampDetailService);

        $this->assertInstanceOf(StudentBootcampDetailController::class, $controller);
    }

}
