<?php

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;
use App\Http\Controllers\api\Student\StudentListController;
use App\Service\Student\StudentListService;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentListControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_student_list_controller_returns_valid_student_data()
    {
        $response = $this->getJson(route('students.list', ['specialization' => 'Data Science,Backend']));

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

        $response = $this->getJson(route('students.list'));

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

        $response = $this->getJson(route('students.list', ['specialization' => 'Data Science,Backend']));

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'fullname' => $student->name . " " . $student->surname,
            'subtitle' => $resume->subtitle,
        ]);

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

    public function testGetResumesWithTags()
    {
        $tag1 = Tag::create(['name' => 'tag1']);
        $tag2 = Tag::create(['name' => 'tag2']);

        $student = Student::factory()->create();

        $resume1 = Resume::factory()->create([
            'student_id' => $student->id,
            'specialization' => 'Frontend',
        ]);
        $resume1->student->tags()->attach($tag1->id);

        $resume2 = Resume::factory()->create([
            'student_id' => $student->id,
            'specialization' => 'Backend',
        ]);
        $resume2->student->tags()->attach($tag2->id);

        $resumeService = new StudentListService();

        $resumes = $resumeService->getResumes(null, ['tag1']);
        $this->assertEquals($resume1->id, $resumes->first()->id);

        $resumes = $resumeService->getResumes(null, ['tag2']);
        $this->assertEquals($resume2->id, $resumes->last()->id);
    }

    public function testStudentListControllerCanBeInstantiated()
    {
        $studentListService = $this->createMock(StudentListService::class);

        $controller = new StudentListController($studentListService);

        $this->assertInstanceOf(StudentListController::class, $controller);
    }
}
