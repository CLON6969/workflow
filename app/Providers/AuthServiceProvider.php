<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Application;
use App\Policies\ApplicationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Application::class => ApplicationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}