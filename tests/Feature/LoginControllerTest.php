<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    public function test_Login_Success()
    {
        $user = User::factory()->create([
            'email' => 'pruebalogin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $requestData = [
            'email' => 'pruebalogin@test.com',
            'password' => 'password123',
        ];

        $response = $this->json('POST', '/api/v1/login', $requestData);

        $response->assertStatus(200)->assertJsonStructure(['token']);

    }

    public function test_a_user_can_login_with_short_password()
    {
        $user = User::factory()->create([
            'email' => fake()->email(),
            'password' => '12345678',
        ]);
        $credentials = [
            'email' => 'jose@gmail.com',
            'password' => '123456',
        ];

        $response = $this->json('POST', '/api/v1/login', $credentials);

        $response->assertStatus(422);

    }

    public function test_a_user_can_login_with_not_email()
    {
        $user = User::factory()->create();
        $credentials = [
            'email',
            'password' => '12345678',
        ];

        $response = $this->json('POST', '/api/v1/login');
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password'])
            ->assertJson([
                'errors' => [
                    'email' => [__('El camp adreça electrònica és obligatori.')],
                    'password' => [__('El camp contrasenya és obligatori.')],
                ],
            ]);

    }

    public function test_login_failure_bad_data()
    {
        $response = $this->post('/api/v1/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => __('Email o contrasenya incorrecte'),
        ]);

    }

    public function test_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/v1/logout');

        $response->assertStatus(200);

        $this->assertNull($user->fresh()->token());

        $response->assertJson(['message' => __('Desconnexió realitzada amb èxit')]);
    }

    public function test_logout_no_auth()
    {

        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/logout');

        $response->assertStatus(401);

        $response->assertJson(['message' => __('Unauthenticated.')]);

        $this->assertNull($response->headers->get('Authorization'));
    }
}
