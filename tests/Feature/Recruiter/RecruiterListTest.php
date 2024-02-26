<?php

namespace Tests\Feature\Recruiter;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class RecruiterListTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        if (! Role::where('name', 'recruiter')->exists()) {
            Role::create(['name' => 'recruiter']);
        }
    }

    public function test_it_returns_a_list_of_recruiters()
    {

        $user = User::factory()->create();
        $user->recruiter()->create([
            'company' => fake()->name(),
            'sector' => 'TIC',
        ]);
        $user->assignRole('recruiter');

        $response = $this->getJson(route('recruiter.list'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'surname',
                    'company',
                    'sector',
                ],
            ],
        ]);
    }
}
