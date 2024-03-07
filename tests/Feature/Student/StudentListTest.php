<?php

namespace Tests\Feature\Student;

use Tests\TestCase;
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
        $response = $this->getJson(route('profiles.home'));

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


}
