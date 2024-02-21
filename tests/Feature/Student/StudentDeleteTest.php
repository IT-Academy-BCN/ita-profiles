<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use App\Models\User;
use Tests\TestCase;

class StudentDeleteTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function a_student_can_be_deleted(): void
    {
        $student = Student::factory()->create();

        $this->withHeaders(['Accept' => 'application/json'])
        ->deleteJson(route('student.delete', $student))
        ->assertStatus(204);
        $this->assertCount(0, Student::all());
        $this->assertDatabaseCount('students', 0);
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
        $this->assertNull(Student::find($student->id));
    }

    /** @test */
    //     public function a_student_cannot_get_unregistered_by_another_student(): void
    //     {
    //         $this->verifyOrCreateRolesAndPermissions();

    //         $user = User::create([
    //             'name' => 'John',
    //             'surname' => 'Doe',
    //             'dni' => '43312254B',
    //             'email' => $email = fake()->email(),
    //             'password' => bcrypt($password = 'password'),
    //         ]);

    //         $user->student()->create([
    //             'subtitle' => 'Enginyer Informàtic i Programador.',
    //             'bootcamp' => 'PHP Developer',
    //         ]);

    //         $user->assignRole('student');

    //         $response = $this->post('api/v1/login', [
    //             'email' => $email,
    //             'password' => $password,
    //         ]);

    //         $this->assertAuthenticatedAs($user);

    //         $this->actingAs($user, 'api');

    //         $response = $this->withHeaders(['Accept' => 'application/json'])->delete('api/v1/students/25');

    //         $response->status(401);

    //     }
}
