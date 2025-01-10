<?php

namespace App\Providers;

use App\Models\Student;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Student::class => StudentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
