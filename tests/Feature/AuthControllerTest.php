<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }



    public function test_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->postJson(route('logout'));

        $response->assertStatus(200);

        $this->assertNull($user->fresh()->token());

        $response->assertJson(['message' => __('Desconnexió realitzada amb èxit')]);
    }

    public function test_logout_no_auth()
    {

        User::factory()->create();

        $response = $this->postJson(route('logout'));

        $response->assertStatus(401);

        $response->assertJson(['message' => __('Unauthenticated.')]);

        $this->assertNull($response->headers->get('Authorization'));
    }
}
