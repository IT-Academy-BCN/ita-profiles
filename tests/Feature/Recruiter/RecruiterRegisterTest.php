<?php

namespace Tests\Feature\Recruiter;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RecruiterRegisterTest extends TestCase
{
    use DatabaseTransactions;


    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    public function verifyOrCreateRole()
    {

        if (!Role::where('name', 'recruiter')->exists()) {
            Role::create(['name' => 'recruier']);

        }

    }

    public function test_create_recruiter_with_valid_data()
    {
        $this->verifyOrCreateRole();

        $userData = [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '33461332N',
            'email' => fake()->email(),
            'password' => 'password123',
            'company' => 'Apple',
            'sector' => 'Telefonia',
        ];

        $response = $this->postJson(route('recruiter.create'), $userData);
        $response->assertHeader('Content-Type', 'application/json');

        $response->assertStatus(201);
        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'surname' => $userData['surname'],
            'dni' => $userData['dni'],
            'email' => $userData['email'],
        ]);

        $this->assertDatabaseHas('recruiters', [
            'user_id' => User::where('email', $userData['email'])->first()->id,
            'company' => $userData['company'],
            'sector' => $userData['sector'],
        ]);

        $user = User::where('email', $userData['email'])->first();
        $this->assertTrue($user->hasRole('recruiter'));

        $response->assertJson([
            'message' => __('Registre realitzat amb èxit.'),
        ]);

    }

    public function test_cant_create_recruiter_with_bad_email()
    {

        $userData = [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '28829324C',
            'email' => 'prueba123',
            'password' => 'password123',
            'company' => 'Apple',
            'sector' => 'Telefonia',
        ];
        $response = $this->postJson(route('recruiter.create'), $userData);
        $response->assertHeader('Content-Type', 'application/json')->assertStatus(422)->assertJson([
            'errors' => [
                'email' => [
                    'Adreça electrònica no és un e-mail vàlid',
                ],
            ],
        ]);

    }

    public static function generateNie(): string
    {
        $prefixes = ['X', 'Y', 'Z'];
        $randomPrefix = $prefixes[array_rand($prefixes)];
        $numbers = str_pad(mt_rand(1, 99999999), 7, '0', STR_PAD_LEFT);
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';

        $checkDigit = $letters[($randomPrefix . $numbers) % 23];

        return $randomPrefix . $numbers . $checkDigit;
    }
}
