<?php

declare(strict_types=1);

namespace Tests\Feature\Policy;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Resume;
use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Auth\Access\Response;

class ProjectPolicyTest extends TestCase
{
	use DatabaseTransactions;

	public function testUpdateAllowsOwner()
	{
		$user = User::factory()->create();
		$student = Student::factory()->create(['user_id' => $user->id]);
		$resume = Resume::factory()->create(['student_id' => $student->id]);
		$project = Project::factory()->create();
		$resume->projects()->attach($project->id);

		$policy = new ProjectPolicy();

		$this->assertEquals(
			$policy->update($user, $project),
			Response::allow()
		);
	}

	public function testUpdateDeniesNonOwner()
	{
		$user = User::factory()->create();
		$user2 = User::factory()->create();
		$student = Student::factory()->create(['user_id' => $user->id]);
		$student2 = Student::factory()->create(['user_id' => $user2->id]);
		$resume = Resume::factory()->create(['student_id' => $student->id]);
		$resume2 = Resume::factory()->create(['student_id' => $student2->id]);
		$project = Project::factory()->create();
		$resume->projects()->attach($project->id);

		$policy = new ProjectPolicy();

		$this->assertEquals(
			$policy->update($user2, $project),
			Response::deny('This action is unauthorized.', 403)
		);
	}
}
