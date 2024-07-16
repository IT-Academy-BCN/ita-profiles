<?php

declare(strict_types=1);

namespace Tests\Feature\Policy;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Resume;

use App\Policies\UserPolicy;

use Illuminate\Auth\Access\Response;

class UserPolicyTest extends TestCase
{

	use DatabaseTransactions;

	public function testNonOwnersAreRestricted()
	{
		$user = User::factory()->create(['id' => '1']);
		$user_2 = User::factory()->create(['id' => '2']);

		$student = Student::factory()->create(['user_id' => $user->id, 'id' => '1']);
		$student_2 = Student::factory()->create(['user_id' => $user_2->id, 'id' => '2']);

		$policy = new UserPolicy();

		$this->assertEquals($policy->canAccessResource($user, $user_2), Response::deny('No tens els permisos per accedir a aquest recurs.'));
	}


	public function testOwnersAreAllowed()
	{
		$user = User::factory()->create(['id' => '1']);
		$user_2 = User::factory()->create(['id' => '2']);

		$student = Student::factory()->create(['user_id' => $user->id, 'id' => '1']);
		$student_2 = Student::factory()->create(['user_id' => $user_2->id, 'id' => '2']);

		$resume = Resume::factory()->create(['student_id' => $student->id, 'id' => '1']);

		$policy = new UserPolicy();

		$this->assertEquals($policy->canAccessResource($user, $user), Response::allow());
	}
}
