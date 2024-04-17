<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use Tests\TestCase;

class StudentBootcampDetailControllerTest extends TestCase
{
    public function testStudentBootcampDetailControllerReturnsData(): void
    {
        $student = Student::whereHas('resume.bootcamps')->first();
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

    public function testStudentBootcampDetailControllerThrowsExceptionWithUnexistentStudent(): void
    {
        $response = $this->getJson(route('bootcamp.list', ['id' => 'unexistent_uuid']));
        $response->assertStatus(404);
        $response->assertJson(['error' => 'Student not found']);
    }

    public function testStudentBootcampDetailControllerReturnsEmptyObjectWithStudentWithoutBootcamp(): void
    {
        $student = Student::whereDoesntHave('resume.bootcamps')->first();
        $response = $this->getJson(route('bootcamp.list', ['id' => $student->id]));
        $response->assertStatus(200);
        $response->assertJson(['bootcamps' => []]);
    }

}