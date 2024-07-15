<?php
declare(strict_types=1);

namespace Tests\Unit\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use Mockery;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;

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
        $this->mockUserPolicy();
    }
	
	
	public function testMockEnsureStudentOwnerMiddlewareSuccess(): void
    {
        
        Route::get('/test-policy', function () {
			$user = User::factory()->create();
			$user_2 = User::factory()->create();
			$policy = new UserPolicy;
			$policy->canAccessResource($user, $user_2);
            return 'Allowed';
        });
        

        $response = $this->get('/test-policy');
        $response->assertStatus(200);
        $response->assertSee('Allowed');
  
    }
	
}
