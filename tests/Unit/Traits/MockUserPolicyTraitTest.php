<?php

declare(strict_types=1);

namespace Tests\Unit\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\User;

use Tests\Traits\MockUserPolicy;


class MockUserPolicyTraitTest extends TestCase
{
    use DatabaseTransactions;
    use MockUserPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->beginMockUserPolicy();
    }

    public function testMockUserPolicySuccess(): void
    {
        // Define a custom route for testing
        $user = User::factory()->create();

        $this->app['router']->get('/test-policy', function () {
            // Fetch the authenticated user
            $user = Auth::user();
            $user_2 = User::factory()->create();

            // Perform authorization check
            if (Gate::allows('canAccessResource', $user_2)) {
                return response('Allowed', 200);
            }
            return response('Forbidden', 403);
        });

        $response = $this->actingAs($user)->get('/test-policy');
        //It should be 403 but thanks to mockery it must be 200
        $response->assertStatus(200);
    }
}
