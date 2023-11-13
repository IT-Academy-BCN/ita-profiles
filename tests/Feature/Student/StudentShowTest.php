<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Models\User;

class StudentShowTest extends TestCase
{

    use RefreshDatabase;
    
    public function verifyOrCreateRole()
    {
        if (!Role::where('name', 'student')->exists()) {
            Role::create(['name' => 'student']);
        }
    }

    /** @test */
    public function a_student_info_can_be_retrieved(): void
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
            'bootcamp'=> 'PHP Developer',
        ]);

        $user -> assignRole('student');

        $response = $this->get('api/v1/students/'.$user->student->id);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }
} 