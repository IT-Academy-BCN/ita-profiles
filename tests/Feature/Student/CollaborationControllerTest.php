<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Collaboration;
use App\Service\CollaborationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CollaborationControllerTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function it_returns_collaboration_details_for_valid_uuid()
    {

        $student = Student::factory()->create();
        $resume = $student->resume()->create();
        $collaboration1 = Collaboration::factory()->create();
        $collaboration2 = Collaboration::factory()->create();
        $resume->collaborations_ids = json_encode([$collaboration1->id, $collaboration2->id]);
        $resume->save();

        $this->app->instance(CollaborationService::class, new CollaborationService());

        $response = $this->getJson(route('collaborations.list', ['student' => $student->id]));

        $response->assertStatus(200)
                 ->assertJsonStructure(['collaborations']);
    }

    /** @test */
    public function it_returns_404_for_invalid_uuid()
    {
        $this->app->instance(CollaborationService::class, new CollaborationService());

        $response = $this->getJson(route('collaborations.list', ['student' => 'nonexistent_uuid']));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_500_for_internal_server_error()
    {

        $this->app->instance(CollaborationService::class, new class {
            public function getCollaborationDetails($uuid)
            {
                throw new Exception();
            }
        });

        $student = Student::factory()->create();
        $student->resume()->create();

        $response = $this->getJson(route('collaborations.list', ['student' => $student->id]));

        $response->assertStatus(500);
    }

}
