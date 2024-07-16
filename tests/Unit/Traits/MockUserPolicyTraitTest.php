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
	//use MockUserPolicy;
	
    protected function setUp(): void
    {
        parent::setUp();
        //$this->beginMockUserPolicy();
    }
	
	/**
     * Handle database transactions on the specified connections.
     *
     * @return void
     */
	//public function testMockEnsureStudentOwnerMiddlewareSuccess(): void
    //{
        
       /*
        Route::get('/test-policy', function () {
			$user = User::factory()->create();
			$user_2 = User::factory()->create();
			$user->save();
			$user_2->save();
			$policy = new UserPolicy;
			//$this->beginMockUserPolicy();
			$result = $policy->canAccessResource($user, $user_2);
			//$user->canAccessResource($user, $user_2);
			 // Use the 'canAccessResource' policy method to authorize the request
            $this->authorize('canAccessResource', $userProfile);
			echo "called\n";
			echo $result."\n";
			var_dump($result);
			return 'Allowed';
			if($result === Response::allow()){
				return 'Allowed';
			}else{
				 return 'Restricted';
			}	
				
           
        });*/
        
        
    public function testMockEnsureStudentOwnerMiddlewareSuccess(): void
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
            
            
            //return response()->json(['message' => 'Authorized']);
        });

        $response = $this->actingAs($user)->get('/test-policy');
        $response->assertStatus(200);
        //$response->assertSee('Allowed');
        //var_dump($response);
        //echo var_dump($response) . "\n";
        //$response->assertOk();
        //$this->assertEquals('Allowed', $response);
  
    }
	
}
