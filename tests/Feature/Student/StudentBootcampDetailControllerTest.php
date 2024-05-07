<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use App\Models\Bootcamp;
use App\Models\Resume;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentBootcampDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentWithoutBootcamps;
    protected $studentWithBootcamps;

    public function setUp(): void
    {
        parent::setUp();

        $this->studentWithoutBootcamps = Resume::factory()->create()->student;

        $resume = Resume::factory()->create();
        $bootcamp = Bootcamp::factory()->create();
        $resume->bootcamps()->attach($bootcamp->id, ['end_date' => now()->subYear()->addDays(rand(1, 365))]);

        $this->studentWithBootcamps = $resume->student;
    }
    public function testGetStudentBootcampDetails(): void
    {
        $response = $this->getJson(route('bootcamp.list', ['id' =>  $this->studentWithBootcamps->id]));
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

    public function testControllerHandlesNonexistentStudent(): void
    {
        $nonexistentUuid = "00000000-0000-0000-0000-000000000000";

        $response = $this->getJson(route('bootcamp.list', ['id' => $nonexistentUuid]));
        $response->assertStatus(404);
        $response->assertJson(['message' => "No s'ha trobat cap estudiant amb aquest ID: $nonexistentUuid"]);
    }

    public function testControllerReturnsEmptyArrayForStudentWithoutBootcamp(): void
    {

        $response = $this->getJson(route('bootcamp.list', ['id' => $this->studentWithoutBootcamps->id]));
        $response->assertStatus(200);
        $response->assertJson(['bootcamps' => []]);
    }

}