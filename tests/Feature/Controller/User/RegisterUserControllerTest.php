<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class RegisterUserControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUserData(): array
    {
        return [
            'username' => 'test_username',
            'dni' => '27827083G',
            'email' => 'test_email@test.com',
            'terms' => 'true',
            'password' => 'Password%123',
            'specialization' => 'Backend',
            'password_confirmation' => 'Password%123',
        ];
    }

    public function test_user_creation_with_valid_data(): void
    {
        $userData = $this->createUserData();
        $response = $this->json('POST', '/api/v1/register', $userData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'email'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => $userData['username'],
            'dni' => $userData['dni'],
            'email' => $userData['email'],
        ]);

        // Additional assertions for related models
        $user = User::where('email', $userData['email'])->first();
        $this->assertDatabaseHas('students', [
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('resumes', [
            'student_id' => $user->student->id,
            'specialization' => $userData['specialization'],
        ]);
    }

    public function test_user_creation_with_invalid_data(): void
    {
        $response = $this->json('POST', '/api/v1/register', [
            'username' => 667677,
            'dni' => 'Invalid DNI',
            'email' => 'invalid_email',
            'terms' => 'false',
            'password' => 'invalid_password',
            'password_confirmation' => 'invalid_password_confirmation',
        ]);

        $response->assertStatus(422); // 422 Unprocessable Entity
        $response->assertJsonValidationErrors(['username', 'dni', 'email', 'password']);
    }

    public function test_required_fields_for_user_creation(): void
    {
        $response = $this->json('POST', '/api/v1/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['username', 'dni', 'email', 'password']);
    }
}
