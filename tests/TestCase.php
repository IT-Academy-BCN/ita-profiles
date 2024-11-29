<?php

namespace Tests;

use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected User $authenticatedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticatedUser = User::factory()->create();
        Passport::actingAs($this->authenticatedUser);
    }

    /**
     * Get the authenticated user.
     *
     * @return User
     */
    protected function authenticatedUser(): User
    {
        return $this->authenticatedUser;
    }
}
