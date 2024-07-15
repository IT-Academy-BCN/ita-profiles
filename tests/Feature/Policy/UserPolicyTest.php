<?php
declare(strict_types=1);

namespace Tests\Feature\Policy;

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
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\Response;

class UserPolicyTest extends TestCase
{
	
	use DatabaseTransactions;
	
	public function test_non_owners_are_restricted()
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
		
		$policy = new UserPolicy();
		
		//$this->assertFalse($policy->canAccessResource($user, $user_2));
		$this->assertEquals($policy->canAccessResource($user, $user_2), Response::deny('No tens els permisos per accedir a aquest recurs.'));
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
		
		$policy = new UserPolicy();
		
		$this->assertEquals($policy->canAccessResource($user, $user), Response::allow());
		
    }

}
