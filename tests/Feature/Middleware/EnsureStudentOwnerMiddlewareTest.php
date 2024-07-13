<?php
declare(strict_types=1);

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use App\Http\Middleware\EnsureStudentOwner;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Resume;
use Illuminate\Foundation\Testing\WithFaker;

use Mockery;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;


class EnsureStudentOwnerMiddlewareTest extends TestCase
{
	
	use DatabaseTransactions;
	
	public function test_non_owners_are_redirected()
    {
		
		// Test users
        $user = User::factory()->create(['id' => '1']);
        $user_2 = User::factory()->create(['id' => '2']);
        
        // Create a student associated with the second user
        $student = Student::factory()->create(['user_id' => $user->id, 'id' => '1']);
		$student_2 = Student::factory()->create(['user_id' => $user_2->id,'id' => '2']);
		
		$user->save();
		$user_2->save();
		$student->save();
		$student_2->save();
		
        // Ensure the authenticated user is the first user
        $this->actingAs($user);
		
		$address = '/api/v1/student/' . $student_2->id . '/resume/skills';
		
        // Define the route with middleware applied
        Route::put('/api/v1/student/{studentId}/resume/skills', function () {
            return 'Success';
        })->middleware(EnsureStudentOwner::class);

        // Simulate a request with a mismatched parameter
        $response = $this->put($address);

        // Assert that the response status is 403 (Unauthorized)
        $response->assertStatus(401);
    }
    
    
    public function test_owners_are_allowed()
    {
		
		// Test users
        $user = User::factory()->create(['id' => '1']);
        $user_2 = User::factory()->create(['id' => '2']);
        
        // Create a student associated with the second user
        $student = Student::factory()->create(['user_id' => $user->id, 'id' => '1']);
		$student_2 = Student::factory()->create(['user_id' => $user_2->id,'id' => '2']);
		
		$resume = Resume::factory()->create(['student_id' => $student->id, 'id' => '1']);
		
		$user->save();
		$user_2->save();
		$student->save();
		$student_2->save();
		$resume->save();
		
        // Ensure the authenticated user is the first user
        $this->actingAs($user);
		
		$address = '/api/v1/student/' . $student->id . '/resume/skills';
		//dd($address);
		
        // Define the route with middleware applied
        Route::put('/api/v1/student/{studentId}/resume/skills', function () {
            return 'Success';
        })->middleware(EnsureStudentOwner::class);

        // Simulate a request with a mismatched parameter
        $data = array('skills' => ["html5", "css", "postman"]);
        //$response = $this->put($address, $data);
		$response = $this->json('PUT', $address, $data);
		//Check that the codes are none of the middleware (redundancy)
		$this->assertNotEquals($response->getStatusCode(), 401);
		$this->assertNotEquals($response->getStatusCode(), 402);
		$this->assertNotEquals($response->getStatusCode(), 404);
		
        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);
    }

}
