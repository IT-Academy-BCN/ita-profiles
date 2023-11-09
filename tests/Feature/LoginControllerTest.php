<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Laravel\Passport\ClientRepository;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */ use RefreshDatabase;
     public function test_a_user_can_login_with_valid_credentials()
     {
         $user = User::factory()->create();
         $credentials = [
             'email' => $user->email,
             'password' => 'Password',
         ];
 
         $this->actingAs($user)->postJson(route('login'), $credentials);
         
       
         $this->assertAuthenticated();
     }

    public function testLoginFailure()
    {
        $response = $this->post('/api/v1/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => __('Usuari o contrasenya incorrectes')
        ]);
        
    }

}
