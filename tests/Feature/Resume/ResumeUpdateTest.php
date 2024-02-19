<?php

namespace Tests\Feature\Resume;

use App\Models\Resume;
use App\Models\Student;
use App\Models\User;
use Database\Factories\UserFactory;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ResumeUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();

    }

    public function tearDown(): void
    {
        $this->artisan('migrate:fresh');
        parent::tearDown();
    }

    public function verifyOrCreateRole()
    {
        if (! Role::where('name', 'student')->exists()) {
            Role::create(['name' => 'student']);
        }
    }

    public function testUpdateMethodInResumeController()
    {
        $this->verifyOrCreateRole();
        $userFactory = new UserFactory();
        $definition = $userFactory->definition();
        $user = new User($definition);
        $user->save();

        $student = new Student();
        $student->setUniqueIds();
        $student->user_id = $user->id;
        $student->subtitle = '';
        $student->save();

        $resume = new Resume();
        $resume->student_id = $student->id;
        $resume->subtitle = '';
        $resume->save();
        $this->actingAs($user, 'api');

        $user->assignRole('student');

        $this->assertTrue($user->hasRole('student'));

        $resumeUpdate = [
            'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'linkedin_url' => 'https://www.linkedin.com',
            'github_url' => 'https://www.github.com',
            'specialization' => 'Frontend',

        ];

        $response = $this->putJson(route('resume.update', [$resume->id]), $resumeUpdate);
        $response->assertHeader('Content-Type', 'application/json');

        $response->assertStatus(200);

        $response->assertJson([
            'message' => __('Currículum actualitzat.'),
        ]);
    }

    public function testUpdateResumeNotFound()
    {

        $this->verifyOrCreateRole();
        $userFactory = new UserFactory();
        $definition = $userFactory->definition();
        $user = new User($definition);
        $user->save();

        $student = new Student();
        $student->setUniqueIds();
        $student->user_id = $user->id;
        $student->subtitle = '';
        $student->save();

        $resume = new Resume();
        $resume->student_id = $student->id;
        $resume->subtitle = '';
        $resume->save();
        $user->assignRole('student');

        $this->actingAs($user, 'api');

        $response = $this->putJson(route('resume.update', [900]));
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(404);

        $response->assertJson([
            'message' => __('Currículum no trobat'),
        ]);
    }
}
