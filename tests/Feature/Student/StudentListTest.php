<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class StudentListTest extends TestCase
{
    use RefreshDatabase;

    public function verifyOrCreateRole()
    {
        if (!Role::where('name', 'student')->exists()) {
            Role::create(['name' => 'student']);
        }
    }


    /** @test */
    public function a_list_of_registered_students_can_be_retrieved(): void
    {
        $this->verifyOrCreateRole();

        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '53671299V',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $user -> student()->create([
            'subtitle' => 'Enginyer Informàtic i Programador.',
            'bootcamp' => 'PHP Developer',
        ]);

        $user -> assignRole('student');

        $response = $this->get('api/v1/students');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonCount(1, 'data');
    }


    /** @test */
    public function a_message_is_retrieved_if_there_are_not_registered_students(): void
    {
        $response = $this->get('api/v1/students');
        $response->assertJson(['message' => __('No hi ha estudiants a la base de dades.')], 404);
    }

}
