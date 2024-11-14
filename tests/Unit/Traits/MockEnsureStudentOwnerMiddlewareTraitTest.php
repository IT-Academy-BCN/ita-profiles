<?php

declare(strict_types=1);

namespace Tests\Unit\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use App\Http\Middleware\EnsureStudentOwner;

use Tests\Traits\MockEnsureStudentOwnerMiddleware;

use Illuminate\Support\Facades\Route;


class MockEnsureStudentOwnerMiddlewareTraitTest extends TestCase
{
    use DatabaseTransactions;
    use MockEnsureStudentOwnerMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->beginMockEnsureStudentOwnerMiddleware();
    }


    public function testMockEnsureStudentOwnerMiddlewareSuccess(): void
    {

        Route::get('/test-middleware/{studentId}/ole', function () {
            return 'Allowed';
        })->middleware(EnsureStudentOwner::class);


        $response = $this->get('/test-middleware/obvious-not-correct-id/ole');
        $response->assertStatus(200);
        $response->assertSee('Allowed');
    }
}
