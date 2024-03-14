<?php

namespace Tests\Feature;

use Tests\TestCase;

class StudentsListTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:fresh');
        parent::tearDown();
    }

    public function testGetStudentList()
    {
        $response = $this->getJson(route('students.list'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'surname',
                    'photo',
                    'status',
                    'id'
                ],
            ],
        ]);
    }
}