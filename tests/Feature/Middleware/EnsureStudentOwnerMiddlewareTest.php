<?php

declare(strict_types=1);

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use App\Http\Middleware\EnsureStudentOwner;
use App\Models\User;
use App\Models\Student;
use App\Models\Resume;

use Illuminate\Support\Facades\Route;


class EnsureStudentOwnerMiddlewareTest extends TestCase
{

    use DatabaseTransactions;

    public function testNonOwnersAreRedirected()
    {
        $user = User::factory()->create(['id' => '1']);
        $user_2 = User::factory()->create(['id' => '2']);

        $student = Student::factory()->create(['user_id' => $user->id, 'id' => '1']);
        $student_2 = Student::factory()->create(['user_id' => $user_2->id, 'id' => '2']);

        // Ensure the authenticated user is the first user
        $this->actingAs($user);

        $address = '/api/v1/student/' . $student_2->id . '/resume/skills';

        // Define the route with middleware applied
        Route::put('/api/v1/student/{studentId}/resume/skills', function () {
            return 'Success';
        })->middleware(EnsureStudentOwner::class);

        // Simulate a request with a mismatched parameter
        $response = $this->put($address);

        $response->assertStatus(403);
    }

    public function testOwnersAreAllowed()
    {
        $user = User::factory()->create(['id' => '1']);
        $user_2 = User::factory()->create(['id' => '2']);

        $student = Student::factory()->create(['user_id' => $user->id, 'id' => '1']);
        $student_2 = Student::factory()->create(['user_id' => $user_2->id, 'id' => '2']);

        $resume = Resume::factory()->create(['student_id' => $student->id, 'id' => '1']);

        // Ensure the authenticated user is the first user
        $this->actingAs($user);

        $address = '/api/v1/student/' . $student->id . '/resume/skills';

        // Define the route with middleware applied
        Route::put('/api/v1/student/{studentId}/resume/skills', function () {
            return 'Success';
        })->middleware(EnsureStudentOwner::class);

        // Simulate a request with a mismatched parameter
        $data = array('skills' => ["html5", "css", "postman"]);
        $response = $this->json('PUT', $address, $data);
        //Check that the codes are none of the middleware (redundancy)
        $this->assertNotEquals($response->getStatusCode(), 401);
        $this->assertNotEquals($response->getStatusCode(), 402);
        $this->assertNotEquals($response->getStatusCode(), 404);

        $response->assertStatus(200);
    }
}
