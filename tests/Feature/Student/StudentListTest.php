<?php

namespace Tests\Feature\Student;

use Tests\TestCase;

class StudentListTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    /** @test */
    public function a_list_of_registered_students_can_be_retrieved(): void
    {

        $response = $this->getJson(route('students.list'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');

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
                'tags',
                'id'
            ]/* ,
        '*.tags.*' => [
            'id',
            'name'
        ] */
        ]);
    }
}
