<?php

namespace Tests\Feature\Recruiter;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecruiterShowTest extends TestCase
{
    use DatabaseTransactions;

    public function test_show_specific_recruiter()
    {

        $user = User::factory()->create();
        $recruiter = $user->recruiter()->create([
            'company' => 'Apple',
            'sector' => 'TIC',
        ]);
        $this->actingAs($user, 'api');
        $response = $this->getJson(route('recruiter.show', ['id' => $recruiter->id]));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonStructure([
            'data' => [
                'name', 'surname', 'company', 'sector',
            ],
        ]);

    }

    public function test_search_recruiter_not_found()
    {
        $response = $this->getJson(route('recruiter.show', ['id' => 34567]));

        $response->assertStatus(404);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'Usuari no trobat.',

        ]);
    }
}
