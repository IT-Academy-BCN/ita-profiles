<?php

namespace Tests\Feature;


use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    public function test_Login_Success()
    {
        User::factory()->create([
            'dni' => '28386914S',
            'password' => bcrypt('password123'),
        ]);

        $credentials = [
            'dni' => '28386914S',
            'password' => 'password123',
        ];

        $response = $this->post(route('login'), $credentials);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_a_user_cannot_login_with_short_password()
    {
        User::factory()->create([
            'dni' => 'Z0038540C',
            'password' => '12345678',
        ]);
        $credentials = [
            'dni' => 'Z0038540C',
            'password' => '123456',
        ];

        $response = $this->post(route('login'), $credentials);

        $response->assertStatus(422);
    }

    public function test_a_user_cannot_login_without_dni_neither_passport()
    {
        User::factory()->create();

        $response = $this->json('POST', '/api/v1/login');
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['dni', 'password'])
            ->assertJson([
                'errors' => [
                    'dni' => [__('El camp dni és obligatori.')],
                    'password' => [__('El camp contrasenya és obligatori.')],
                ],
            ]);
    }

    public function test_login_failure_bad_data()
    {
        $response = $this->post(route('login'), [
            'dni' => 'Z0038540C',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => __('Dni-Nie o contrasenya incorrecte'),
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

        User::factory()->create();

        $response = $this->postJson('/api/v1/logout');

        $response->assertStatus(401);

        $response->assertJson(['message' => __('Unauthenticated.')]);

        $this->assertNull($response->headers->get('Authorization'));
    }
}
