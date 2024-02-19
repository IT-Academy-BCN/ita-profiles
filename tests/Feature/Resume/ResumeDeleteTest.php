<?php

namespace Tests\Feature\Resume;

use App\Models\Resume;
use App\Models\Student;
use App\Models\User;
use Database\Factories\UserFactory;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ResumeDeleteTest extends TestCase
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

    public function testDeletemethodInResumeController()
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

        $response = $this->deleteJson(route('resume.delete', ['id' => $resume->id]));
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $response->assertJson([
            'message' => __('Currículum eliminat.'),
        ]);
    }

    public function testDeleteResumeNotFound()
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

        $response = $this->deleteJson(route('resume.delete', [900]));
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(404);

        $response->assertJson([
            'message' => __('Currículum no trobat'),
        ]);
    }
}
