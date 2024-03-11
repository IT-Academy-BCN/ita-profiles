<?php

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Resume;
use App\Models\Student;
use App\Service\StudentListService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentListTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
        $this->artisan('migrate:fresh --seed');
    }

    public function test_student_list_controller()
    {
        $response = $this->getJson(route('profiles.home', ['specialization' => 'Data Science,Backend']));
        
        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'fullname',
                'subtitle',
                'photo',
                'tags' => [
                    '*' => [
                        'id',
                        'name'
                    ],
                ],
            ],
        ]);
    }

    public function test_student_list_controller_throws_exception()
    {
        $this->mock(StudentListService::class, function ($mock) {
            $mock->shouldReceive('execute')
                ->andThrow(new ModelNotFoundException('No hi ha resums', 404));
        });

        $response = $this->getJson(route('profiles.home'));

        $response->assertStatus(404);
        $response->assertJson(['message' => 'No hi ha resums']);
    }
    public function test_specialization_filter_returns_correct_students()
    {
        $specialization = 'Backend';
        $student = Student::factory()->create();
        $resume = Resume::factory()->create([
            'student_id' => $student->id,
            'specialization' => $specialization,
        ]);
        $response = $this->getJson(route('profiles.home', ['specialization' => 'Data Science,Backend']));

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'fullname' => $student->name . " " . $student->surname,
            'subtitle' => $resume->subtitle,
        ]);
        // Comprobar directamente en la base de datos
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => $student->name,
            'surname' => $student->surname,
        ]);

        $this->assertDatabaseHas('resumes', [
            'id' => $resume->id,
            'student_id' => $student->id,
            'specialization' => $specialization,
        ]);
        $fetchedResume = Resume::with('student')->find($resume->id);
        $this->assertNotNull($fetchedResume);
        $this->assertTrue($fetchedResume->student->is($student));
    }
}
