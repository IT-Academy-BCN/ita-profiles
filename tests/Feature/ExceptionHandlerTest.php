<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Validator;
use Exception;

class ExceptionHandlerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Definición de rutas ficticias para pruebas
        Route::get('api/test/model-not-found', function () {
            throw new ModelNotFoundException('Resource not found');
        });

        Route::post('api/test/validation-error', function (Request $request) {
            throw new ValidationException(Validator::make([], []));
        });

        Route::get('api/test/authorization-error', function () {
            throw new AuthorizationException('This action is unauthorized.');
        });

        Route::get('api/test/http-error', function () {
            throw new HttpException(500, 'Http exception');
        });

        Route::get('api/test/general-error', function () {
            throw new Exception('General exception');
        });
    }

    public function test_model_not_found()
    {
        $response = $this->getJson('api/test/model-not-found');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Resource not found',
            ]);
    }

    public function test_validation_exception()
    {
        $response = $this->postJson('api/test/validation-error');

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Validation failed',
            ]);
    }

    public function test_authorization_exception()
    {
        $response = $this->getJson('api/test/authorization-error');

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.',
            ]);
    }

    public function test_http_exception()
    {
        $response = $this->getJson('api/test/http-error');

        $response->assertStatus(500)
            ->assertJson([
                'message' => 'Http exception',
            ]);
    }

    public function test_general_exception()
    {
        $response = $this->getJson('api/test/general-error');

        $response->assertStatus(500)
            ->assertJson([
                'message' => 'General exception',
            ]);
    }
}
