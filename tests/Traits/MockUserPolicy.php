<?php
declare(strict_types=1);
namespace Tests\Traits;

use Illuminate\Support\Facades\Gate;
use Mockery;
use Illuminate\Auth\Access\Response;

trait MockUserPolicy
{
    protected function mockUserPolicy()
    {	
		/*
        Gate::define("user.$method", function () use ($returnValue) {
            return $returnValue;
        });*/
        //Mockering Policy
		$userPolicyMockery= Mockery::mock('App\Policies\UserPolicy');
		$userPolicyMockery->shouldReceive('canAccessResource')->once()
			->andReturn(Response::allow());
		$this->app->instance('App\Policies\UserPolicy', $userPolicyMockery);
        
    }
}
