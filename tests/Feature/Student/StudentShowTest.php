<?php

namespace Tests\Feature\Student;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StudentShowTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    public function verifyOrCreateRole()
    {
        if (! Role::where('name', 'student')->exists()) {
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
            'dni' => '71858753Z',
            'email' => fake()->email(),
            'password' => 'password123',
        ]);

        $user->student()->create([
            'subtitle' => 'Enginyer Informàtic i Programador.',
            'bootcamp' => 'PHP Developer',
        ]);

        $user->assignRole('student');

        $response = $this->get('api/v1/students/'.$user->student->id);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }
}
