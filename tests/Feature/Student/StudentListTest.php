<?php

namespace Tests\Feature\Student;

use Tests\TestCase;

class StudentListTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
        $this->artisan('migrate:fresh --seed');
    }

    /**
     * @test
     * @group OpenEndpoints
     */
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
}
