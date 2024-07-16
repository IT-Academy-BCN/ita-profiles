<?php
declare(strict_types=1);

namespace Tests\Unit\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use Mockery;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Http\Middleware\EnsureStudentOwner;
use App\Models\Resume;
use App\Models\User;
use App\Models\Student;

use App\Policies\UserPolicy;
use Illuminate\Auth\Access\Response;

use Tests\Traits\MockUserPolicy;

use Illuminate\Support\Facades\Route;


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
		$user_2 = User::factory()->create();
		$user->save();
		$user_2->save();
        
        $this->app['router']->get('/test-policy', function () {
            // Fetch the authenticated user
			$user = Auth::user();
			$user_2 = User::factory()->create();
			$user_2->save();
            //$this->authorize('canAccessResource', $user);
            //return 'Allowed';
            
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
