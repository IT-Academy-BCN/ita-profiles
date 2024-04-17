<?php

namespace Tests\Feature\Student;

use App\Models\Bootcamp;
use App\Models\Resume;
use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentBootcampDetailControllerTest extends TestCase
{
    use DatabaseTransactions;
    public function testGetStudentBootcampDetails(): void
    {
        $student = Student::factory()->create();
        $resume = Resume::factory()->create(['student_id' => $student->id]);
        $bootcamp = Bootcamp::factory()->create();
        $resume->bootcamps()->attach($bootcamp->id, ['end_date' => now()->subYear()->addDays(rand(1, 365))]);

        $response = $this->getJson(route('bootcamp.list', ['id' => $student->id]));
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
        $nonexistentUuid = Student::max('id') . 'A';
        $response = $this->getJson(route('bootcamp.list', ['id' => $nonexistentUuid]));
        $response->assertStatus(404);
        $response->assertJson(['error' => 'Student not found']);
    }

    public function testControllerReturnsEmptyArrayForStudentWithoutBootcamp(): void
    {
        $student = Student::factory()->create();
        Resume::factory()->create(['student_id' => $student->id]);

        $response = $this->getJson(route('bootcamp.list', ['id' => $student->id]));
        $response->assertStatus(200);
        $response->assertJson(['bootcamps' => []]);
    }

}


