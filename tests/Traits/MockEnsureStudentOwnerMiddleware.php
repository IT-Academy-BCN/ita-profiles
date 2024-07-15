<?php
declare(strict_types=1);
namespace Tests\Traits;
use Illuminate\Support\Facades\Route;
use Mockery;

trait MockEnsureStudentOwnerMiddleware{
	
	/**
     * Handle database transactions on the specified connections.
     *
     * @return void
     */
    function beginMockEnsureStudentOwnerMiddleware()
    { 
		
		//Mockering middleware
		$ensureStudentMiddleware = Mockery::mock('App\Http\Middleware\EnsureStudentOwner[handle]');
		$ensureStudentMiddleware->shouldReceive('handle')
			->andReturnUsing(function($request, \Closure $next) {
				return $next($request);
			});
		$this->app->instance('App\Http\Middleware\EnsureStudentOwner', $ensureStudentMiddleware);
		
		/*
		Route::middleware([\App\Http\Middleware\EnsureStudentOwner::class])->group(function () use ($callback) {
            $callback();
        });
		*/
	}
	
	protected function setUp(): void
    {
        parent::setUp();
        $this->beginMockEnsureStudentOwnerMiddleware();
    }
}
